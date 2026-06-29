<?php

namespace App\Services;

use Exception;

class MarcosService
{
    public function process(array $data, array $weights)
    {
        if (empty($data)) {
            return [];
        }

        $totalWeight = array_sum($weights);
        if (round($totalWeight, 2) != 1) {
            throw new Exception('Total bobot kriteria harus bernilai 1');
        }

        if (count(reset($data)) != count($weights)) {
            throw new Exception('Jumlah kriteria dan bobot tidak sesuai');
        }

        // Langkah 1 & 2: Cari AI dan AAI, lalu lakukan Normalisasi MARCOS
        $normalizedData = $this->normalizeMarcos($data);

        // Langkah 3: Hitung Matriks Terbobot (V)
        $weightedData = $this->weightingMarcos($normalizedData, $weights);

        // Langkah 4 & 5: Hitung Nilai Utilitas & Fungsi Kompromi Akhir untuk Ranking
        return $this->rankingMarcos($weightedData);
    }

    private function normalizeMarcos(array $data)
    {
        $m = count($data);
        $n = count(reset($data));

        // Cari Solusi Ideal (AI) dan Anti-Ideal (AAI) untuk kriteria Benefit
        $ai = [];
        $aai = [];
        for ($j = 0; $j < $n; $j++) {
            $columnValues = array_column($data, $j);
            $ai[$j] = max($columnValues);
            $aai[$j] = min($columnValues);
        }

        $normalized = [];
        foreach ($data as $alternative => $values) {
            foreach ($values as $j => $value) {
                // Normalisasi Alternatif (X) terhadap AI
                $normalized[$alternative][$j] = $ai[$j] > 0 ? $value / $ai[$j] : 0;
            }
        }

        // Normalisasi untuk baris AAI terhadap AI (Aturan khas MARCOS)
        foreach ($ai as $j => $aiValue) {
            $normalized['AAI'][$j] = $ai[$j] > 0 ? $aai[$j] / $ai[$j] : 0;
            $normalized['AI'][$j] = 1.0; // AI dibagi AI hasilnya pasti 1
        }

        return $normalized;
    }

    private function weightingMarcos(array $normalized, array $weights)
    {
        $weighted = [];
        foreach ($normalized as $alternative => $values) {
            foreach ($values as $j => $value) {
                $weighted[$alternative][$j] = $value * $weights[$j];
            }
        }
        return $weighted;
    }

    private function rankingMarcos(array $weighted)
    {
        // Hitung nilai S untuk setiap baris (Total matriks terbobot per alternatif)
        $s = [];
        foreach ($weighted as $alternative => $values) {
            $s[$alternative] = array_sum($values);
        }

        $s_aai = $s['AAI'];
        $s_ai = $s['AI'];

        // Hapus baris pembantu AI dan AAI agar tidak ikut diranking ke user
        unset($s['AI'], $s['AAI']);

        $results = [];
        foreach ($s as $alternative => $s_i) {
            // Langkah 4: Hitung Tingkat Utilitas Ki- dan Ki+
            $ki_minus = $s_aai > 0 ? $s_i / $s_aai : 0;
            $ki_plus = $s_ai > 0 ? $s_i / $s_ai : 0;

            // Langkah 5: Hitung Fungsi Utilitas Kompromi f(Ki)
            $f_ki_minus = $ki_plus / ($ki_plus + $ki_minus + 0.00001); // menghindari devide by zero
            $f_ki_plus = $ki_minus / ($ki_plus + $ki_minus + 0.00001);

            $f_ki = ($ki_plus + $ki_minus) / (1 + ((1 - $f_ki_plus) / ($ki_plus + 0.00001)) + ((1 - $f_ki_minus) / ($ki_minus + 0.00001)));

            $results[$alternative] = $f_ki;
        }

        // Urutkan dari nilai tertinggi ke terendah
        arsort($results);

        $rank = 1;
        $finalRanking = [];
        foreach ($results as $alternative => $score) {
            $finalRanking[] = [
                'alternatif' => $alternative,
                'score' => round($score, 4),
                'rank' => $rank++
            ];
        }

        return $finalRanking;
    }
}