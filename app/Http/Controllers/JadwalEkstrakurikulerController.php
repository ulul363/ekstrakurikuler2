<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\JadwalEkstrakurikuler;
use Illuminate\Http\Request;

class JadwalEkstrakurikulerController extends Controller
{
    public function index()
    {
        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::with('ekstrakurikuler')->get();
        return view('jadwal_ekstrakurikuler.index', compact('jadwalEkstrakurikuler'));
    }

    public function create()
    {
        $ekstrakurikuler = Ekstrakurikuler::all();
        return view('jadwal_ekstrakurikuler.create', compact('ekstrakurikuler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'hari' => 'required|string|max:8',
            'waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:30',
        ]);

        JadwalEkstrakurikuler::create($request->all());

        return redirect()->route('jadwal_ekstrakurikuler.index')->with('success', 'Jadwal Ekstrakurikuler berhasil dibuat.');
    }

    public function edit($id)
    {
        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::findOrFail($id);
        $ekstrakurikuler = Ekstrakurikuler::all();
        return view('jadwal_ekstrakurikuler.edit', compact('jadwalEkstrakurikuler', 'ekstrakurikuler'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'hari' => 'required|string|max:8',
            'waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:30',
        ]);

        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::findOrFail($id);
        $jadwalEkstrakurikuler->update([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('jadwal_ekstrakurikuler.index')->with('success', 'Jadwal Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::findOrFail($id);
        $jadwalEkstrakurikuler->delete();

        return redirect()->route('jadwal_ekstrakurikuler.index')->with('success', 'Jadwal Ekstrakurikuler berhasil dihapus.');
    }
}