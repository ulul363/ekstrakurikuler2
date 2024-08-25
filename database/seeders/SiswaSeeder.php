<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus semua data dari tabel 'siswa'
        DB::table('siswa')->truncate();

        // Data yang ingin Anda masukkan ke dalam tabel
        $data = [
            [
                'nis' => '112233',
                'nama' => 'Auliya',
                'alamat' => 'Damalang',
                'jenis_kelamin' => 'P',
                'email' => 'auliya@gmail.com',
                'no_hp' => '0897637281634',
            ],
            [
                'nis' => '123457',
                'nama' => 'Mohammad Ulul Azmi',
                'alamat' => 'Sidanegara',
                'jenis_kelamin' => 'L',
                'email' => 'ulul@gmail.com',
                'no_hp' => '0895340452388',
            ],
        ];

        // Masukkan data ke dalam tabel 'siswa'
        DB::table('siswa')->insert($data);
    }
}
