<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\PenilaianEkstrakurikuler;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Ambil data sesuai Role
        if ($user->hasRole('Admin')) {
            $prestasis = \App\Models\Prestasi::with(['ekstrakurikuler', 'ketua'])->get();
        } elseif ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            if (!$pembina) {
                abort(403, 'Data Pembina tidak ditemukan');
            }
            $prestasis = \App\Models\Prestasi::with(['ekstrakurikuler', 'ketua'])
                ->where('ekstrakurikuler_id', $pembina->ekstrakurikuler_id)->get();
        } else {
            $ketua = $user->ketua;
            if (!$ketua) {
                abort(403, 'Data Ketua tidak ditemukan');
            }
            $prestasis = \App\Models\Prestasi::with(['ekstrakurikuler', 'ketua'])
                ->where('ketua_id', $ketua->id_ketua)->get();
        }

        // 2. Lempar variabel $prestasis ke file view index.blade.php
        return view('prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        $ketua = auth()->user()->ketua;

        $daftaranggota = \App\Models\DaftarAnggota::where('ekstrakurikuler_id', $ketua->ekstrakurikuler_id)->get();

        return view('prestasi.create', compact('daftaranggota'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'prestasi' => 'required|string|max:100',
            'tingkat' => 'required|in:kabupaten,provinsi,nasional',
            'nama_siswa' => 'required|array',
            'tahun_ajaran' => 'required|integer',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $ketua = auth()->user()->ketua;
        if (!$ketua) {
            return back()->withErrors('User bukan ketua');
        }

        $file = $request->file('berkas')->store('prestasi', 'public');

        Prestasi::create([
            'ekstrakurikuler_id' => $ketua->ekstrakurikuler_id,
            'ketua_id' => $ketua->id_ketua,
            'prestasi' => $request->prestasi,
            'tingkat' => $request->tingkat,
            'nama_siswa' => $request->nama_siswa,
            'tahun_ajaran' => $request->tahun_ajaran,
            'berkas' => $file,
            'status' => 'pending',
        ]);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $data = Prestasi::findOrFail($id);
        $data->update([
            'status' => $request->status,
            'pembina_id' => auth()->user()->pembina?->id_pembina,
        ]);

        // 🔥 LOGIKA INTEGRASI SPK MARCOS (C2 Prestasi)
        if ($request->status === 'disetujui') {
            // Ambil total akumulasi skor prestasi dari model booted() otomatis
            $totalSkorPrestasi = Prestasi::where('ekstrakurikuler_id', $data->ekstrakurikuler_id)
                ->where('status', 'disetujui')
                ->sum('skor_prestasi');

            PenilaianEkstrakurikuler::updateOrCreate(
                ['ekstrakurikuler_id' => $data->ekstrakurikuler_id],
                ['c2_prestasi' => $totalSkorPrestasi]
            );
        }

        return back()->with('success', 'Prestasi diverifikasi');
    }
}