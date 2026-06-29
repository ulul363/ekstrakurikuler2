<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPertemuan;
use App\Models\PenilaianEkstrakurikuler;
use Illuminate\Http\Request;

class PengajuanPertemuanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $pertemuan = PengajuanPertemuan::all();
        } elseif ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            if (!$pembina) {
                abort(403, 'Pembina tidak ditemukan');
            }
            // Tambahkan with() untuk memanggil relasi agar aman di view
            $pertemuan = PengajuanPertemuan::with(['ekstrakurikuler', 'ketua'])
                ->where('ekstrakurikuler_id', $pembina->ekstrakurikuler_id)->get();
        } else {
            $ketua = $user->ketua;
            if (!$ketua) {
                abort(403, 'Ketua tidak ditemukan');
            }
            $pertemuan = PengajuanPertemuan::with(['ekstrakurikuler', 'ketua'])
                ->where('ketua_id', $ketua->id_ketua)->get();
        }

        return view('pertemuan.index', compact('pertemuan'));
    }

    // 👇 INI FUNGSI CREATE YANG HILANG 👇
    public function create()
    {
        return view('pertemuan.create');
        // Pastikan nama folder view-nya 'pertemuan' dan ada file 'create.blade.php'
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_pertemuan' => 'required|string|max:150',
            'tanggal_rencana' => 'required|date',
            'waktu_rencana' => 'required',
            'agenda_pertemuan' => 'required|string',
        ]);

        $ketua = auth()->user()->ketua;

        PengajuanPertemuan::create([
            'ekstrakurikuler_id' => $ketua->ekstrakurikuler_id,
            'ketua_id' => $ketua->id_ketua,
            'judul_pertemuan' => $request->judul_pertemuan,
            'tanggal_rencana' => $request->tanggal_rencana,
            'waktu_rencana' => $request->waktu_rencana,
            'agenda_pertemuan' => $request->agenda_pertemuan,
            'status' => 'pending',
        ]);

        // 👇 PERBAIKAN: Harus REDIRECT, bukan return view 👇
        return redirect()->route('pertemuan.index')->with('success', 'Pengajuan pertemuan berhasil terkirim.');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_pembina' => 'nullable|string',
        ]);

        $pertemuan = PengajuanPertemuan::findOrFail($id);
        $pertemuan->update([
            'status' => $request->status,
            'keterangan_pembina' => $request->keterangan_pembina,
            'pembina_id' => auth()->user()->pembina?->id_pembina,
        ]);

        // LOGIKA INTEGRASI SPK MARCOS (C4 Intensitas Pertemuan)
        if ($request->status === 'disetujui') {
            $jumlahPertemuan = PengajuanPertemuan::where('ekstrakurikuler_id', $pertemuan->ekstrakurikuler_id)
                ->where('status', 'disetujui')
                ->count();

            PenilaianEkstrakurikuler::updateOrCreate(
                ['ekstrakurikuler_id' => $pertemuan->ekstrakurikuler_id],
                ['c4_intensitas' => $jumlahPertemuan]
            );
        }

        return back()->with('success', 'Status pengajuan pertemuan diperbarui.');
    }
}