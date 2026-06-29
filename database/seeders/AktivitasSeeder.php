<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AktivitasSeeder extends Seeder
{
    public function run()
    {
        // 1. PROGRAM KEGIATAN
        $prokerData = [
            ['ekstrakurikuler_id' => 1, 'ketua_id' => 2, 'pembina_id' => 8, 'nama_program' => 'Latihan Rutin Pengibaran', 'tahun_ajaran' => 2024, 'deskripsi' => 'Latihan PBB rutin mingguan', 'status' => 'disetujui', 'status_pelaksanaan' => 'terlaksana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 1, 'ketua_id' => 2, 'pembina_id' => 8, 'nama_program' => 'Lomba PBB Kabupaten', 'tahun_ajaran' => 2024, 'deskripsi' => 'Lomba HUT RI', 'status' => 'pending', 'status_pelaksanaan' => 'belum', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 2, 'ketua_id' => 3, 'pembina_id' => 9, 'nama_program' => 'Persami', 'tahun_ajaran' => 2024, 'deskripsi' => 'Penerimaan tamu ambalan', 'status' => 'disetujui', 'status_pelaksanaan' => 'terlaksana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 3, 'ketua_id' => 4, 'pembina_id' => 10, 'nama_program' => 'Donor Darah Massal', 'tahun_ajaran' => 2024, 'deskripsi' => 'Kegiatan donor darah PMI', 'status' => 'disetujui', 'status_pelaksanaan' => 'terlaksana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 4, 'ketua_id' => 5, 'pembina_id' => 11, 'nama_program' => 'Pentas Seni Akhir Tahun', 'tahun_ajaran' => 2024, 'deskripsi' => 'Pementasan drama kolosal', 'status' => 'ditolak', 'status_pelaksanaan' => 'belum', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('program_kegiatan')->insert($prokerData);

        // 2. PENGAJUAN PERTEMUAN
        $pertemuanData = [
            ['ekstrakurikuler_id' => 1, 'ketua_id' => 2, 'pembina_id' => 8, 'judul_pertemuan' => 'Persiapan Lomba', 'tanggal_rencana' => '2024-07-20', 'waktu_rencana' => '15:30:00', 'agenda_pertemuan' => 'Membahas formasi', 'status' => 'disetujui', 'keterangan_pembina' => 'Oke', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 3, 'ketua_id' => 4, 'pembina_id' => 10, 'judul_pertemuan' => 'Koordinasi Baksos', 'tanggal_rencana' => '2024-08-01', 'waktu_rencana' => '13:00:00', 'agenda_pertemuan' => 'Pembagian tugas', 'status' => 'pending', 'keterangan_pembina' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 4, 'ketua_id' => 5, 'pembina_id' => 11, 'judul_pertemuan' => 'Casting Aktor', 'tanggal_rencana' => '2024-08-10', 'waktu_rencana' => '15:00:00', 'agenda_pertemuan' => 'Pemilihan peran', 'status' => 'ditolak', 'keterangan_pembina' => 'Jadwal bentrok dengan ujian', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('pengajuan_pertemuan')->insert($pertemuanData);

        // 3. KEHADIRAN
        $kehadiranData = [
            ['ekstrakurikuler_id' => 1, 'ketua_id' => 2, 'pembina_id' => 8, 'nama_kegiatan' => 'Latihan Rutin Minggu 1', 'tahun_ajaran' => 2024, 'tanggal' => '2024-07-15', 'deskripsi' => 'Latihan dasar', 'berkas' => 'dummy/kehadiran1.pdf', 'jumlah_hadir' => 48, 'jumlah_anggota' => 50, 'status' => 'disetujui', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 2, 'ketua_id' => 3, 'pembina_id' => 9, 'nama_kegiatan' => 'Pionering', 'tahun_ajaran' => 2024, 'tanggal' => '2024-07-18', 'deskripsi' => 'Praktek', 'berkas' => 'dummy/kehadiran2.pdf', 'jumlah_hadir' => 35, 'jumlah_anggota' => 40, 'status' => 'pending', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 3, 'ketua_id' => 4, 'pembina_id' => 10, 'nama_kegiatan' => 'Latihan P3K', 'tahun_ajaran' => 2024, 'tanggal' => '2024-07-22', 'deskripsi' => 'Balut bidai', 'berkas' => 'dummy/kehadiran3.pdf', 'jumlah_hadir' => 28, 'jumlah_anggota' => 30, 'status' => 'disetujui', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('kehadiran')->insert($kehadiranData);

        // 4. PRESTASI
        $prestasiData = [
            ['ekstrakurikuler_id' => 1, 'ketua_id' => 2, 'pembina_id' => 8, 'prestasi' => 'Juara 1 PBB', 'tingkat' => 'provinsi', 'skor_prestasi' => 80, 'nama_siswa' => json_encode(["Siti Nurhaliza"]), 'tahun_ajaran' => 2024, 'berkas' => 'dummy/piagam1.pdf', 'status' => 'disetujui', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 2, 'ketua_id' => 3, 'pembina_id' => 9, 'prestasi' => 'Juara Umum Pionering', 'tingkat' => 'kabupaten', 'skor_prestasi' => 60, 'nama_siswa' => json_encode(["Auliya", "Bintang Pratama"]), 'tahun_ajaran' => 2024, 'berkas' => 'dummy/piagam2.pdf', 'status' => 'pending', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ekstrakurikuler_id' => 4, 'ketua_id' => 5, 'pembina_id' => 11, 'prestasi' => 'Juara 2 Monolog Nasional', 'tingkat' => 'nasional', 'skor_prestasi' => 100, 'nama_siswa' => json_encode(["Zidni Azizati"]), 'tahun_ajaran' => 2024, 'berkas' => 'dummy/piagam3.pdf', 'status' => 'disetujui', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('prestasi')->insert($prestasiData);
    }
}