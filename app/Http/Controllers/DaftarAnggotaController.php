<?php

namespace App\Http\Controllers;

use App\Models\DaftarAnggota;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class DaftarAnggotaController extends Controller
{
    public function index()
    {
        $daftaranggota = DaftarAnggota::with('ekstrakurikuler')->get();
        return view('daftaranggota.index', compact('daftaranggota'));
    }

    public function create()
    {
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('daftaranggota.create', compact('ekstrakurikulers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'nis' => 'required|integer|unique:daftar_anggota,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
        ]);

        DaftarAnggota::create($request->all());

        return redirect()->route('daftaranggota.index')->with('success', 'Daftar Anggota berhasil ditambahkan.');
    }

    public function edit(DaftarAnggota $daftaranggota)
    {
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('daftaranggota.edit', compact('daftaranggota', 'ekstrakurikulers'));
    }

    public function update(Request $request, DaftarAnggota $daftaranggota)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'nis' => 'required|integer|unique:daftar_anggota,nis,' . $daftaranggota->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
        ]);

        $daftaranggota->update($request->all());

        return redirect()->route('daftaranggota.index')->with('success', 'Daftar Anggota berhasil diupdate.');
    }


    public function destroy(DaftarAnggota $daftaranggota)
    {
        $daftaranggota->delete();

        return redirect()->route('daftaranggota.index')->with('success', 'Daftar Anggota berhasil dihapus.');
    }
}
