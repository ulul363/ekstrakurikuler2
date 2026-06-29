<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        // Hindari error foreign key jika ada tabel lain yg pakai data siswa
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('siswa')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['nis' => '112233', 'nama' => 'Auliya', 'alamat' => 'Damalang', 'jenis_kelamin' => 'P', 'email' => 'auliya@gmail.com', 'no_hp' => '0897637281634'],
            ['nis' => '123457', 'nama' => 'Mohammad Ulul Azmi', 'alamat' => 'Sidanegara', 'jenis_kelamin' => 'L', 'email' => 'ulul@gmail.com', 'no_hp' => '0895340452388'],
            ['nis' => '123458', 'nama' => 'Bintang Pratama', 'alamat' => 'Karangtengah', 'jenis_kelamin' => 'L', 'email' => 'bintang@gmail.com', 'no_hp' => '081223344556'],
            ['nis' => '123459', 'nama' => 'Siti Nurhaliza', 'alamat' => 'Sayung', 'jenis_kelamin' => 'P', 'email' => 'siti@gmail.com', 'no_hp' => '085677889900'],
            ['nis' => '123460', 'nama' => 'Dwi Saputra', 'alamat' => 'Mranggen', 'jenis_kelamin' => 'L', 'email' => 'dwi@gmail.com', 'no_hp' => '089911223344'],
            ['nis' => '123461', 'nama' => 'Rina Melati', 'alamat' => 'Karanganyar', 'jenis_kelamin' => 'P', 'email' => 'rina@gmail.com', 'no_hp' => '082133445566'],
        ];

        DB::table('siswa')->insert($data);
    }
}