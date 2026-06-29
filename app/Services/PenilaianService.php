<?php

namespace App\Services;

use App\Models\Ekstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;

class PenilaianService
{
    public function getDecisionMatrix(): array
    {
        $ekskuls = Ekstrakurikuler::all();
        $matrix = [];

        foreach ($ekskuls as $ekskul) {
            // Perbaikan: Gunakan where() dan first() agar mengambil 1 baris objek data penilaian yang tepat
            $penilaian = PenilaianEkstrakurikuler::where('ekstrakurikuler_id', $ekskul->id_ekstrakurikuler)->first();

            // Skip jika ekskul tersebut belum memiliki record nilai sama sekali
            if (!$penilaian) {
                continue;
            }

            // Perbaikan: Hanya mengambil 4 Kriteria (C1-C4) sesuai kesepakatan hapus C5
            $matrix[$ekskul->nama] = [
                (float) ($penilaian->c1_kehadiran ?? 0),
                (float) ($penilaian->c2_prestasi ?? 0),
                (float) ($penilaian->c3_program_kerja ?? 0),
                (float) ($penilaian->c4_intensitas ?? 0),
            ];
        }

        return $matrix;
    }

    public function isValidForRanking(array $matrix): bool
    {
        // Minimal ada 2 alternatif ekstrakurikuler agar proses perangkingan bernilai logis
        return count($matrix) >= 2;
    }
}