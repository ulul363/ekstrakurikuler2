<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Kriteria;
use App\Models\Ekstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Services\MarcosService;
use App\Services\PenilaianService;

class RankingController extends Controller
{
    public function index(
        PenilaianService $penilaianService,
        MarcosService $marcos
    ) {

        $data = $penilaianService->getDecisionMatrix();

        if (!$penilaianService->isValidForRanking($data)) {

            return view('ranking.index', [
                'ranking' => [],
                'message' => 'Data penilaian belum cukup untuk perhitungan ranking'
            ]);
        }

        $weights = Kriteria::orderBy('kode')
            ->pluck('bobot')
            ->map(fn($bobot) => $bobot / 100)
            ->toArray();

        try {

            $ranking = $marcos->process(
                $data,
                $weights
            );

            foreach ($ranking as $item) {

                $ekskul = Ekstrakurikuler::where(
                    'nama',
                    $item['alternatif']
                )->first();

                if ($ekskul) {

                    PenilaianEkstrakurikuler::where(
                        'ekstrakurikuler_id',
                        $ekskul->id_ekstrakurikuler
                    )->update([
                                'nilai_akhir' => $item['score'],
                                'ranking' => $item['rank']
                            ]);
                }
            }

            return view(
                'ranking.index',
                compact('ranking')
            );

        } catch (Exception $e) {

            return view('ranking.index', [
                'ranking' => [],
                'message' => $e->getMessage()
            ]);
        }
    }
}