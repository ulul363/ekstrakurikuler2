<?php

namespace App\Http\Controllers;

use App\Models\Ketua;
use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\Kehadiran;
use App\Models\ProgramKegiatan;
use App\Models\JadwalEkstrakurikuler;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $nama_ekskul = 'Semua Ekstrakurikuler'; // Default untuk Admin
        $role_name = 'Admin';

        if ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            if (!$pembina) {
                abort(403, 'Pembina data not found.');
            }

            $ekstrakurikulerId = $pembina->ekstrakurikuler_id;
            $nama_ekskul = $pembina->ekstrakurikuler->nama_ekstrakurikuler ?? 'Belum ada ekstrakurikuler';
            $role_name = 'Pembina';

            $prestasi = Prestasi::with(['ekstrakurikuler', 'ketua'])->where('ekstrakurikuler_id', $ekstrakurikulerId)->get();
            $kehadiran = Kehadiran::with(['ekstrakurikuler', 'ketua'])->where('ekstrakurikuler_id', $ekstrakurikulerId)->get();
            $programKegiatan = ProgramKegiatan::with(['ekstrakurikuler', 'ketua'])->where('ekstrakurikuler_id', $ekstrakurikulerId)->get();

        } elseif ($user->hasRole('Ketua')) {
            $ketua = $user->ketua;
            if (!$ketua) {
                abort(403, 'Ketua tidak ditemukan');
            }

            $nama_ekskul = $ketua->ekstrakurikuler->nama_ekstrakurikuler ?? 'Belum ada ekstrakurikuler';
            $role_name = 'Ketua';

            $prestasi = Prestasi::with(['ekstrakurikuler', 'ketua'])->where('ketua_id', $ketua->id_ketua)->get();
            $kehadiran = Kehadiran::with(['ekstrakurikuler', 'ketua'])->where('ketua_id', $ketua->id_ketua)->get();
            $programKegiatan = ProgramKegiatan::with(['ekstrakurikuler', 'ketua'])->where('ketua_id', $ketua->id_ketua)->get();

        } else {
            $prestasi = Prestasi::all();
            $kehadiran = Kehadiran::all();
            $programKegiatan = ProgramKegiatan::all();
        }

        $jadwalEkstrakurikuler = JadwalEkstrakurikuler::with('ekstrakurikuler')->get();

        // HITUNG TOTAL
        $totalPrestasi = count($prestasi);
        $totalKehadiran = count($kehadiran);
        $totalProker = count($programKegiatan);
        $totalJadwal = count($jadwalEkstrakurikuler);

        // DATA CHART
        $chartData = [
            'disetujui' => $programKegiatan->where('status', 'disetujui')->count() + $kehadiran->where('status', 'disetujui')->count() + $prestasi->where('status', 'disetujui')->count(),
            'pending' => $programKegiatan->where('status', 'pending')->count() + $kehadiran->where('status', 'pending')->count() + $prestasi->where('status', 'pending')->count(),
            'ditolak' => $programKegiatan->where('status', 'ditolak')->count() + $kehadiran->where('status', 'ditolak')->count() + $prestasi->where('status', 'ditolak')->count(),
        ];

        // Lempar $nama_ekskul dan $role_name ke view
        return view('dashboard', compact(
            'prestasi',
            'kehadiran',
            'programKegiatan',
            'jadwalEkstrakurikuler',
            'totalPrestasi',
            'totalKehadiran',
            'totalProker',
            'totalJadwal',
            'chartData',
            'nama_ekskul',
            'role_name'
        ));
    }
}