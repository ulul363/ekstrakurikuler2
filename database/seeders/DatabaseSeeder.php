<?php

namespace Database\Seeders;

use App\Models\DaftarAnggota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Permission & Roles
        $this->createPermissions();
        $this->createAdminRole();
        $this->createKetuaAndPembinaRoles();

        // 2. Data Master Dasar
        $this->insertEkstrakurikuler();

        // 3. User & Relasi
        $this->createKetuaUsers();
        $this->createPembinaUsers();
        $this->insertJadwalEkstrakurikuler();
        $this->createDaftarAnggota();

        // 4. Seeder Tambahan
        $this->call([
            SiswaSeeder::class,
            KriteriaSeeder::class,
            AktivitasSeeder::class,
            PenilaianEkstrakurikulerSeeder::class,
        ]);
    }

    private function createPermissions()
    {
        $permissions = [
            // Admin Core
            'user.index',
            'user.create',
            'user.store',
            'user.edit',
            'user.update',
            'user.destroy',
            'role.index',
            'role.create',
            'role.store',
            'role.edit',
            'role.update',
            'role.destroy',
            'dashboard',
            'pembina.index',
            'ketua.index',
            'ekstrakurikuler.index',
            'jadwal_ekstrakurikuler.index',
            'laporan.index',
            'laporan.exportPDF',
            'daftaranggota.index',

            // Program Kegiatan
            'program_kegiatan.index',
            'program_kegiatan.create',
            'program_kegiatan.store',
            'program_kegiatan.edit',
            'program_kegiatan.update',
            'program_kegiatan.destroy',
            'program_kegiatan.show',
            'program_kegiatan.verifikasi',

            // Kehadiran
            'kehadiran.index',
            'kehadiran.create',
            'kehadiran.store',
            'kehadiran.edit',
            'kehadiran.update',
            'kehadiran.destroy',
            'kehadiran.show',
            'kehadiran.verifikasi',

            // Prestasi
            'prestasi.index',
            'prestasi.create',
            'prestasi.store',
            'prestasi.edit',
            'prestasi.update',
            'prestasi.destroy',
            'prestasi.show',
            'prestasi.verifikasi',

            // Pertemuan
            'pertemuan.index',
            'pertemuan.create',
            'pertemuan.store',
            'pertemuan.edit',
            'pertemuan.update',
            'pertemuan.destroy',
            'pertemuan.show',
            'pertemuan.verifikasi',

            // Chat
            'chat.index',
            'chat.show',
            'chat.store',

            // Daftar Anggota
            'daftaranggota.index',
            'daftaranggota.create',
            'daftaranggota.store',
            'daftaranggota.edit',
            'daftaranggota.update',
            'daftaranggota.destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
    private function createAdminRole()
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions(Permission::all());

        if (!User::where('email', 'admin@example.com')->exists()) {
            $adminUser = User::create([
                'name' => 'Admin MAN Demak',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $adminUser->assignRole($adminRole);
        }
    }

    private function createKetuaAndPembinaRoles()
    {
        // 1. Atur Role & Permission untuk KETUA
        $ketuaRole = Role::firstOrCreate(['name' => 'Ketua']);
        $ketuaPermissions = [
            'dashboard',
            'program_kegiatan.index',
            'program_kegiatan.create',
            'program_kegiatan.store',
            'program_kegiatan.edit',
            'program_kegiatan.update',
            'program_kegiatan.destroy',
            'program_kegiatan.show',
            'kehadiran.index',
            'kehadiran.create',
            'kehadiran.store',
            'kehadiran.edit',
            'kehadiran.update',
            'kehadiran.destroy',
            'kehadiran.show',
            'prestasi.index',
            'prestasi.create',
            'prestasi.store',
            'prestasi.edit',
            'prestasi.update',
            'prestasi.destroy',
            'prestasi.show',
            'pertemuan.index',
            'pertemuan.create',
            'pertemuan.store',
            'pertemuan.edit',
            'pertemuan.update',
            'pertemuan.destroy',
            'pertemuan.show',
            // 👇 PERBAIKANNYA DI SINI BANG 👇
            // 👇 Akses Penuh untuk Ketua 👇
            'daftaranggota.index',
            'daftaranggota.create',
            'daftaranggota.store',
            'daftaranggota.edit',
            'daftaranggota.update',
            'daftaranggota.destroy',
            'chat.index',
            'chat.show',
            'chat.store',
        ];
        $ketuaRole->syncPermissions($ketuaPermissions);


        // 2. Atur Role & Permission untuk PEMBINA
        $pembinaRole = Role::firstOrCreate(['name' => 'Pembina']);
        $pembinaPermissions = [
            'dashboard',
            'program_kegiatan.index',
            'program_kegiatan.store',
            'program_kegiatan.show',
            'program_kegiatan.verifikasi',
            'kehadiran.index',
            'kehadiran.store',
            'kehadiran.show',
            'kehadiran.verifikasi',
            'prestasi.index',
            'prestasi.store',
            'prestasi.show',
            'prestasi.verifikasi',
            'pertemuan.index',
            'pertemuan.store',
            'pertemuan.show',
            'pertemuan.verifikasi',
            // 👇 PERBAIKANNYA DI SINI BANG 👇
            'daftaranggota.index',
            'chat.index',
            'chat.show',
            'chat.store',
        ];
        $pembinaRole->syncPermissions($pembinaPermissions);
    }
    private function insertEkstrakurikuler()
    {
        $ekstrakurikulerData = [
            ['id_ekstrakurikuler' => 1, 'nama' => 'Paskibra', 'deskripsi' => 'Pasukan Pengibar Bendera', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_ekstrakurikuler' => 2, 'nama' => 'Pramuka', 'deskripsi' => 'Praja Muda Karana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_ekstrakurikuler' => 3, 'nama' => 'PMR', 'deskripsi' => 'Palang Merah Remaja', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_ekstrakurikuler' => 4, 'nama' => 'Teater', 'deskripsi' => 'Seni Peran dan Teater', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($ekstrakurikulerData as $data) {
            DB::table('ekstrakurikuler')->insertOrIgnore($data);
        }
    }

    private function createKetuaUsers()
    {
        $this->createKetuaUser(2, 'Aden Muhammad Noor', 'aden@gmail.com', 'password', 1, '220037', 'Aden Muhammad Noor');
        $this->createKetuaUser(3, 'Aisya Khosyi', 'aisya@gmail.com', 'password', 2, '220002', 'Aisya Khosyi');
        $this->createKetuaUser(4, 'Bagus Adlim', 'bagus@gmail.com', 'password', 3, '220044', 'Bagus Adlim Aqil');
        $this->createKetuaUser(5, 'Zidni Azizati', 'zidni@gmail.com', 'password', 4, '220036', 'Zidni Azizati');
    }

    private function createKetuaUser($userId, $name, $email, $password, $ekskulId, $nis, $nama)
    {
        $ketuaRole = Role::where('name', 'Ketua')->first();
        if (!User::where('email', $email)->exists()) {
            $ketuaUser = User::create(['id' => $userId, 'name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
            $ketuaUser->assignRole($ketuaRole);
            DB::table('ketua')->insert(['id_ketua' => $userId, 'user_id' => $ketuaUser->id, 'ekstrakurikuler_id' => $ekskulId, 'nama' => $nama, 'nis' => $nis, 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
    }

    private function createPembinaUsers()
    {
        $this->createPembinaUser(8, 'Mohamad Taufiq', 'taufiq@gmail.com', 'password', 1, '197012311234567890', 'Mohamad Taufiq');
        $this->createPembinaUser(9, 'Anik Hudayati', 'anik@gmail.com', 'password', 2, '196904122345678901', 'Anik Hudayati');
        $this->createPembinaUser(10, 'Himmatul Aliyah', 'himmatul@gmail.com', 'password', 3, '197511233456789012', 'Himmatul Aliyah');
        $this->createPembinaUser(11, 'Wahid Anwar', 'wahid@gmail.com', 'password', 4, '197204277890123456', 'Wahid Anwar');
    }

    private function createPembinaUser($userId, $name, $email, $password, $ekskulId, $nip, $nama)
    {
        $pembinaRole = Role::where('name', 'Pembina')->first();
        if (!User::where('email', $email)->exists()) {
            $pembinaUser = User::create(['id' => $userId, 'name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
            $pembinaUser->assignRole($pembinaRole);
            DB::table('pembina')->insert(['id_pembina' => $userId, 'user_id' => $pembinaUser->id, 'ekstrakurikuler_id' => $ekskulId, 'nip' => $nip, 'nama' => $nama, 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
    }

    private function insertJadwalEkstrakurikuler()
    {
        $jadwalEkstrakurikulerData = [
            ['id_jadwal_ekstrakurikuler' => 1, 'ekstrakurikuler_id' => 1, 'hari' => 'Senin', 'waktu' => '15:30', 'lokasi' => 'Lapangan Utama', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_jadwal_ekstrakurikuler' => 2, 'ekstrakurikuler_id' => 2, 'hari' => 'Jumat', 'waktu' => '14:00', 'lokasi' => 'Lapangan Basket', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_jadwal_ekstrakurikuler' => 3, 'ekstrakurikuler_id' => 3, 'hari' => 'Kamis', 'waktu' => '15:00', 'lokasi' => 'Ruang UKS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_jadwal_ekstrakurikuler' => 4, 'ekstrakurikuler_id' => 4, 'hari' => 'Rabu', 'waktu' => '15:00', 'lokasi' => 'Aula Serbaguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($jadwalEkstrakurikulerData as $data) {
            DB::table('jadwal_ekstrakurikuler')->insertOrIgnore($data);
        }
    }

    private function createDaftarAnggota()
    {
        // Asumsi Ekstrakurikuler ID 1 = Pramuka, ID 2 = Paskibra (Sesuaikan dengan data Abang)
        DaftarAnggota::create([
            'ekstrakurikuler_id' => 1,
            'nis' => '100123',
            'nama' => 'Budi Santoso',
            'kelas' => 'X MIPA 1'
        ]);

        DaftarAnggota::create([
            'ekstrakurikuler_id' => 1,
            'nis' => '100124',
            'nama' => 'Siti Aminah',
            'kelas' => 'X MIPA 2'
        ]);
    }
}