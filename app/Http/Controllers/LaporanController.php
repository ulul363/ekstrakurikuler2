<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\ProgramKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\JadwalEkstrakurikuler;

class LaporanController extends Controller
{
    public function index()
    {
        $programKegiatan = ProgramKegiatan::with('ekstrakurikuler', 'ketua', 'pembina')->get();
        $kehadiran = Kehadiran::with('ekstrakurikuler', 'ketua', 'pembina')->get();
        $prestasi = Prestasi::with('ekstrakurikuler', 'ketua', 'pembina')->get();
        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::with('ekstrakurikuler')->get();

        $tahunAjaranProgramKegiatan = ProgramKegiatan::distinct()->pluck('tahun_ajaran');
        $tahunAjaranKehadiran = Kehadiran::distinct()->pluck('tahun_ajaran');
        $tahunAjaranPrestasi = Prestasi::distinct()->pluck('tahun_ajaran');

        return view('laporan.index', compact('programKegiatan', 'kehadiran', 'prestasi', 'jadwalEkstrakurikuler', 'tahunAjaranProgramKegiatan', 'tahunAjaranKehadiran', 'tahunAjaranPrestasi'));
    }

    public function exportPDF(Request $request)
    {
        $type = $request->input('type'); // 'program_kegiatan', 'kehadiran', 'prestasi'
        $ekstrakurikuler_id = $request->input('ekstrakurikuler_id');
        $tahun_ajaran = $request->input('tahun_ajaran');
        $status = $request->input('status'); // 'pending', 'disetujui', 'ditolak'

        $query = null;

        if ($type == 'program_kegiatan') {
            $query = ProgramKegiatan::where('tahun_ajaran', $tahun_ajaran)->with('ekstrakurikuler', 'ketua', 'pembina');

            if ($ekstrakurikuler_id) {
                $query->where('ekstrakurikuler_id', $ekstrakurikuler_id);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $data = $query->get();

            if ($data->isEmpty()) {
                return redirect()->route('laporan.index')->with('error', 'Data Program Kegiatan tidak ditemukan.');
            }

            $pdf = PDF::loadView('laporan.pdf.program_kegiatan', compact('data'));
        } elseif ($type == 'kehadiran') {
            $query = Kehadiran::where('tahun_ajaran', $tahun_ajaran)->with('ekstrakurikuler', 'ketua', 'pembina');

            if ($ekstrakurikuler_id) {
                $query->where('ekstrakurikuler_id', $ekstrakurikuler_id);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $data = $query->get();

            if ($data->isEmpty()) {
                return redirect()->route('laporan.index')->with('error', 'Data Kehadiran tidak ditemukan.');
            }

            $pdf = PDF::loadView('laporan.pdf.kehadiran', compact('data'));
        } elseif ($type == 'prestasi') {
            $query = Prestasi::where('tahun_ajaran', $tahun_ajaran)->with('ekstrakurikuler', 'ketua', 'pembina');

            if ($ekstrakurikuler_id) {
                $query->where('ekstrakurikuler_id', $ekstrakurikuler_id);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $data = $query->get();

            if ($data->isEmpty()) {
                return redirect()->route('laporan.index')->with('error', 'Data Prestasi tidak ditemukan.');
            }

            $pdf = PDF::loadView('laporan.pdf.prestasi', compact('data'));
        }

        return $pdf->download('laporan.pdf');
    }
}
