<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatan;
use App\Models\PenilaianEkstrakurikuler;
use Illuminate\Http\Request;

class ProgramKegiatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            // Admin bisa melihat semua program kegiatan
            $programKegiatan = ProgramKegiatan::all();
        } elseif ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            if (!$pembina) {
                abort(403, 'Pembina tidak ditemukan');
            }
            $programKegiatan = ProgramKegiatan::where('ekstrakurikuler_id', $pembina->ekstrakurikuler_id)->get();
        } else {
            $ketua = $user->ketua;
            if (!$ketua) {
                abort(403, 'Ketua tidak ditemukan');
            }
            $programKegiatan = ProgramKegiatan::where('ketua_id', $ketua->id_ketua)->get();
        }

        return view('program_kegiatan.index', compact('programKegiatan'));
    }

    public function create()
    {
        return view('program_kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:50',
            'tahun_ajaran' => 'required|integer',
            'deskripsi' => 'required|string|max:200',
        ]);

        $ketua = auth()->user()->ketua;
        if (!$ketua) {
            return back()->withErrors('User bukan ketua');
        }

        ProgramKegiatan::create([
            'ekstrakurikuler_id' => $ketua->ekstrakurikuler_id,
            'ketua_id' => $ketua->id_ketua,
            'nama_program' => $request->nama_program,
            'tahun_ajaran' => $request->tahun_ajaran,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return redirect()->route('program_kegiatan.index')->with('success', 'Program berhasil dibuat');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'status_pelaksanaan' => 'required|in:belum,terlaksana',
            'keterangan' => 'nullable|string',
        ]);

        $program = ProgramKegiatan::findOrFail($id);
        $program->update([
            'status' => $request->status,
            'status_pelaksanaan' => $request->status_pelaksanaan,
            'keterangan' => $request->keterangan,
            'pembina_id' => auth()->user()->pembina?->id_pembina,
        ]);

        // 🔥 LOGIKA INTEGRASI SPK MARCOS (C3 Program Kerja)
        if ($request->status === 'disetujui') {
            $totalProker = ProgramKegiatan::where('ekstrakurikuler_id', $program->ekstrakurikuler_id)->where('status', 'disetujui')->count();
            $prokerTerlaksana = ProgramKegiatan::where('ekstrakurikuler_id', $program->ekstrakurikuler_id)->where('status', 'disetujui')->where('status_pelaksanaan', 'terlaksana')->count();

            // Mengukur persentase ketercapaian proker kerja
            $persentaseCapaian = $totalProker > 0 ? ($prokerTerlaksana / $totalProker) * 100 : 0;

            PenilaianEkstrakurikuler::updateOrCreate(
                ['ekstrakurikuler_id' => $program->ekstrakurikuler_id],
                ['c3_program_kerja' => $persentaseCapaian]
            );
        }

        return back()->with('success', 'Program kerja berhasil diverifikasi');
    }
}