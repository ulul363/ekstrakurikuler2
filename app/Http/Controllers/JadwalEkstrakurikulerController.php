<?php

namespace App\Http\Controllers;

use App\Models\JadwalEkstrakurikuler;
use Illuminate\Http\Request;

class JadwalEkstrakurikulerController extends Controller
{
    public function index()
    {
        // Ubah nama variabel dari $data menjadi $jadwalEkstrakurikuler
        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::with('ekstrakurikuler')->get();

        // Pastikan nama folder view-nya cocok (jadwal_ekstrakurikuler.index) 
        // dan kirim variabel dengan nama yang baru
        return view('jadwal_ekstrakurikuler.index', compact('jadwalEkstrakurikuler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
        ]);

        JadwalEkstrakurikuler::create($request->all());

        return back();
    }
}