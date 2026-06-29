<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianEkstrakurikulerSeeder extends Seeder
{
    public function run()
    {
        DB::table('penilaian_ekstrakurikuler')->truncate();

        // Data C1(Kehadiran%), C2(Skor Prestasi), C3(Proker Terlaksana%), C4(Total Pertemuan Disetujui)
        $data = [
            [
                'ekstrakurikuler_id' => 1, // Paskibra
                'c1_kehadiran' => 96.0,
                'c2_prestasi' => 80.0,
                'c3_program_kerja' => 50.0,
                'c4_intensitas' => 1.0,
            ],
            [
                'ekstrakurikuler_id' => 2, // Pramuka
                'c1_kehadiran' => 87.5,
                'c2_prestasi' => 60.0,
                'c3_program_kerja' => 100.0,
                'c4_intensitas' => 1.0,
            ],
            [
                'ekstrakurikuler_id' => 3, // PMR
                'c1_kehadiran' => 93.3,
                'c2_prestasi' => 0.0, // Belum ada prestasi yang diapprove
                'c3_program_kerja' => 100.0,
                'c4_intensitas' => 0.0, // Pertemuan masih pending
            ],
            [
                'ekstrakurikuler_id' => 4, // Teater (Peringkatnya mungkin akan tinggi karena C2 = 100)
                'c1_kehadiran' => 85.0,
                'c2_prestasi' => 100.0,
                'c3_program_kerja' => 0.0, // Ditolak
                'c4_intensitas' => 0.0,
            ],
        ];

        DB::table('penilaian_ekstrakurikuler')->insert($data);
    }
}