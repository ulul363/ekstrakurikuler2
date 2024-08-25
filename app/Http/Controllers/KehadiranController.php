<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Auth;
use App\Models\EkstrakurikulerPembina;
use Illuminate\Support\Facades\Storage;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            // dd($pembina);
            if (!$pembina) {
                abort(403, 'Pembina data not found.');
            }

            $kehadiran = Kehadiran::where('pembina_id', $pembina->id_pembina)->get();
        } else {
            $ketuaId = $user->ketua->id_ketua;
            $kehadiran = Kehadiran::with('ekstrakurikuler', 'ketua', 'pembina')
                ->where('ketua_id', $ketuaId)
                ->get();
        }

        return view('kehadiran.index', compact('kehadiran'));
    }

    public function verifikasi(Request $request, $id)
    {
        $kehadiran = Kehadiran::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $kehadiran->status = $request->input('status');
        $kehadiran->keterangan = $request->input('keterangan');
        $kehadiran->pembina_id = auth()->user()->pembina->id_pembina;
        $kehadiran->save();

        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil diverifikasi.');
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
            'deskripsi' => 'required|string|max:200',
            'berkas' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($user->ketua) {
            $ekstrakurikuler = Ekstrakurikuler::where('ketua_id', $user->id)->first();

            if (!$ekstrakurikuler) {
                return redirect()->route('kehadiran.create')->withErrors('Ekstrakurikuler tidak ditemukan.');
            }

            $pembina = $ekstrakurikuler->pembina()->first();
            // dd($pembina->id_pembina); // Mengambil pembina dari relasi

            if (!$pembina) {
                return redirect()->route('kehadiran.create')->withErrors('Tidak ada pembina yang terdaftar untuk ekstrakurikuler ini.');
            }

            $berkasPath = null;

            if ($request->hasFile('berkas')) {
                $berkas = $request->file('berkas');
                $fileName = time() . '.' . $berkas->getClientOriginalExtension();
                $berkasPath = $berkas->storeAs('uploads/kehadiran', $fileName, 'public');
            }

            Kehadiran::create([
                'ekstrakurikuler_id' => $ekstrakurikuler->id_ekstrakurikuler,
                'ketua_id' => $user->ketua->id_ketua,
                'pembina_id' => $pembina->id_pembina, // Pastikan ini valid
                'nama_kegiatan' => $request->nama_kegiatan,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'berkas' => $berkasPath,
                'status' => 'pending',
            ]);

            return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil diajukan.');
        } else {
            return redirect()->route('kehadiran.create')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }
    }


    public function edit($id)
    {
        $kehadiran = Kehadiran::findOrFail($id);
        return view('kehadiran.edit', compact('kehadiran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tahun_ajaran' => 'required|integer',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:200',
            'berkas' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // max 2MB
        ]);

        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->update($request->all());

        if ($request->hasFile('berkas')) {
            // Hapus file lama jika ada
            if (Storage::disk('public')->exists($kehadiran->berkas)) {
                Storage::disk('public')->delete($kehadiran->berkas);
            }

            // Upload file baru
            $fileName = time();
            $filePath = $request->file('berkas')->storeAs('uploads/kehadiran', $fileName, 'public');
            $kehadiran->berkas = $filePath;
        }

        $kehadiran->save();

        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kehadiran = Kehadiran::findOrFail($id);

        if (Storage::disk('public')->exists($kehadiran->berkas)) {
            Storage::disk('public')->delete($kehadiran->berkas);
        }

        $kehadiran->delete();

        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil dihapus.');
    }

    public function show($id)
    {
        $kehadiran = Kehadiran::with('ekstrakurikuler', 'ketua', 'pembina')->findOrFail($id);
        return response()->json($kehadiran);
    }
}
