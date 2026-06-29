<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\PenilaianEkstrakurikuler;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $kehadiran = Kehadiran::all();
        } elseif ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            if (!$pembina) {
                abort(403, 'Pembina tidak ditemukan');
            }
            $kehadiran = Kehadiran::where('ekstrakurikuler_id', $pembina->ekstrakurikuler_id)->get();
        } else {
            $ketua = $user->ketua;
            if (!$ketua) {
                abort(403, 'Ketua tidak ditemukan');
            }
            $kehadiran = Kehadiran::where('ketua_id', $ketua->id_ketua)->get();
        }

        return view('kehadiran.index', compact('kehadiran'));
    }

    public function create()
    {
        return view('kehadiran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tahun_ajaran' => 'required|integer',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_anggota' => 'required|integer|min:1',
        ]);

        $ketua = auth()->user()->ketua;
        if (!$ketua) {
            return back()->withErrors('User bukan ketua');
        }

        $file = $request->file('berkas')->store('kehadiran', 'public');

        Kehadiran::create([
            'ekstrakurikuler_id' => $ketua->ekstrakurikuler_id,
            'ketua_id' => $ketua->id_ketua,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'berkas' => $file,
            'jumlah_hadir' => $request->jumlah_hadir,
            'jumlah_anggota' => $request->jumlah_anggota,
            'status' => 'pending',
        ]);

        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil diajukan!');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_pembina' => 'nullable|string', // Pastikan nama field ini sama dengan di form Blade
        ]);

        $data = Kehadiran::findOrFail($id);

        $data->update([
            'status' => $request->status,
            'keterangan_pembina' => $request->keterangan_pembina, // Ini penambahannya
            'pembina_id' => auth()->user()->pembina?->id_pembina,
        ]);

        // Logika MARCOS Abang (Sudah OK!)
        if ($request->status === 'disetujui') {
            $allKehadiran = Kehadiran::where('ekstrakurikuler_id', $data->ekstrakurikuler_id)
                ->where('status', 'disetujui')
                ->get();

            $totalPersentase = 0;
            foreach ($allKehadiran as $kehadiran) {
                $totalPersentase += ($kehadiran->jumlah_hadir / $kehadiran->jumlah_anggota) * 100;
            }
            $rataRata = $allKehadiran->count() > 0 ? $totalPersentase / $allKehadiran->count() : 0;

            PenilaianEkstrakurikuler::updateOrCreate(
                ['ekstrakurikuler_id' => $data->ekstrakurikuler_id],
                ['c1_kehadiran' => $rataRata]
            );
        }

        return back()->with('success', 'Status kehadiran berhasil diverifikasi.');
    }
}