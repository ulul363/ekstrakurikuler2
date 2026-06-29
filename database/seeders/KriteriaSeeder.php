<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('kriteria')->truncate();

        $data = [
            ['kode' => 'C1', 'nama_kriteria' => 'Kehadiran Pertemuan', 'bobot' => 30.00, 'atribut' => 'benefit'],
            ['kode' => 'C2', 'nama_kriteria' => 'Capaian Prestasi', 'bobot' => 25.00, 'atribut' => 'benefit'],
            ['kode' => 'C3', 'nama_kriteria' => 'Realisasi Program Kerja', 'bobot' => 25.00, 'atribut' => 'benefit'],
            ['kode' => 'C4', 'nama_kriteria' => 'Intensitas Pertemuan', 'bobot' => 20.00, 'atribut' => 'benefit'],
        ];

        DB::table('kriteria')->insert($data);
    }
}