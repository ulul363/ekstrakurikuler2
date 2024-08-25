<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ketua;
use App\Models\Pembina;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Create Permissions
        $this->createPermissions();

        // Step 2: Create Admin Role
        $this->createAdminRole();

        // Step 3: Create Ketua and Pembina Roles
        $this->createKetuaAndPembinaRoles();

        // Step 4: Create Ketua Users
        // $this->createKetuaUsers();

        // Step 5: Create Pembina Users
        // $this->createPembinaUsers();

        // Step 6: Insert Ekstrakurikuler
        // $this->insertEkstrakurikuler();

        // Step 7: Insert Jadwal Ekstrakurikuler
        // $this->insertJadwalEkstrakurikuler();
    }


    private function createPermissions()
    {
        $permissions = [
            // Admin Permissions
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
            'role.getRoutesAllJson',
            'role.getRefreshAndDeleteJson',
            'dashboard',
            'pembina.index',
            'pembina.create',
            'pembina.store',
            'pembina.edit',
            'pembina.update',
            'pembina.destroy',
            'pembina.createuser',
            'pembina.storeuser',
            'pembina.updateUser',
            'ketua.index',
            'ketua.create',
            'ketua.store',
            'ketua.edit',
            'ketua.update',
            'ketua.destroy',
            'ketua.createuser',
            'ketua.storeuser',
            'ketua.updateUser',
            'ekstrakurikuler.index',
            'ekstrakurikuler.create',
            'ekstrakurikuler.store',
            'ekstrakurikuler.edit',
            'ekstrakurikuler.update',
            'ekstrakurikuler.destroy',
            'jadwal_ekstrakurikuler.index',
            'jadwal_ekstrakurikuler.create',
            'jadwal_ekstrakurikuler.store',
            'jadwal_ekstrakurikuler.edit',
            'jadwal_ekstrakurikuler.update',
            'jadwal_ekstrakurikuler.destroy',
            'laporan.index',
            'laporan.exportPDF',
            // Ketua Permissions
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
            'chat.show',
            'chat.store',
            'daftaranggota.index',
            'daftaranggota.create',
            'daftaranggota.store',
            'daftaranggota.edit',
            'daftaranggota.update',
            'daftaranggota.destroy',
            'daftaranggota.show',
            // Pembina Permissions
            'program_kegiatan.store',
            'program_kegiatan.show',
            'program_kegiatan.verifikasi',
            'kehadiran.store',
            'kehadiran.show',
            'kehadiran.verifikasi',
            'prestasi.store',
            'prestasi.show',
            'prestasi.verifikasi',
            'pertemuan.store',
            'pertemuan.show',
            'pertemuan.verifikasi',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }

    private function createAdminRole()
    {
        if (!Role::where('name', 'Admin')->exists()) {
            $adminRole = Role::create(['name' => 'Admin']);

            $adminPermissions = ['user.index', 'user.create', 'user.store', 'user.edit', 'user.update', 'user.destroy', 'role.index', 'role.create', 'role.store', 'role.edit', 'role.update', 'role.destroy', 'role.getRoutesAllJson', 'role.getRefreshAndDeleteJson', 'dashboard', 'pembina.index', 'pembina.create', 'pembina.store', 'pembina.edit', 'pembina.update', 'pembina.destroy', 'pembina.createuser', 'pembina.storeuser', 'pembina.updateUser', 'ketua.index', 'ketua.create', 'ketua.store', 'ketua.edit', 'ketua.update', 'ketua.destroy', 'ketua.createuser', 'ketua.storeuser', 'ketua.updateUser', 'ekstrakurikuler.index', 'ekstrakurikuler.create', 'ekstrakurikuler.store', 'ekstrakurikuler.edit', 'ekstrakurikuler.update', 'ekstrakurikuler.destroy', 'jadwal_ekstrakurikuler.index', 'jadwal_ekstrakurikuler.create', 'jadwal_ekstrakurikuler.store', 'jadwal_ekstrakurikuler.edit', 'jadwal_ekstrakurikuler.update', 'jadwal_ekstrakurikuler.destroy', 'laporan.index', 'laporan.exportPDF'];

            foreach ($adminPermissions as $permission) {
                $adminRole->givePermissionTo($permission);
            }

            if (!User::where('email', 'admin@example.com')->exists()) {
                $adminUser = User::create([
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('password'),
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $adminUser->assignRole($adminRole);
            }
        }
    }

    private function createKetuaAndPembinaRoles()
    {
        // Create Ketua Role
        if (!Role::where('name', 'Ketua')->exists()) {
            $ketuaRole = Role::create(['name' => 'Ketua']);
            $ketuaPermissions = ['dashboard', 'program_kegiatan.index', 'program_kegiatan.create', 'program_kegiatan.store', 'program_kegiatan.edit', 'program_kegiatan.update', 'program_kegiatan.destroy', 'program_kegiatan.show', 'kehadiran.index', 'kehadiran.create', 'kehadiran.store', 'kehadiran.edit', 'kehadiran.update', 'kehadiran.destroy', 'kehadiran.show', 'prestasi.index', 'prestasi.create', 'prestasi.store', 'prestasi.edit', 'prestasi.update', 'prestasi.destroy', 'prestasi.show', 'pertemuan.index', 'pertemuan.create', 'pertemuan.store', 'pertemuan.edit', 'pertemuan.update', 'pertemuan.destroy', 'pertemuan.show', 'chat.show', 'chat.store', 'daftaranggota.index', 'daftaranggota.create', 'daftaranggota.store', 'daftaranggota.edit', 'daftaranggota.update', 'daftaranggota.destroy', 'daftaranggota.show'];
            foreach ($ketuaPermissions as $permission) {
                $ketuaRole->givePermissionTo($permission);
            }
        }

        // Create Pembina Role
        if (!Role::where('name', 'Pembina')->exists()) {
            $pembinaRole = Role::create(['name' => 'Pembina']);
            $pembinaPermissions = ['dashboard', 'program_kegiatan.index', 'program_kegiatan.store', 'program_kegiatan.show', 'program_kegiatan.verifikasi', 'kehadiran.index', 'kehadiran.store', 'kehadiran.show', 'kehadiran.verifikasi', 'prestasi.index', 'prestasi.store', 'prestasi.show', 'prestasi.verifikasi', 'pertemuan.index', 'pertemuan.store', 'pertemuan.show', 'pertemuan.verifikasi', 'chat.show', 'chat.store', 'daftaranggota.index', 'daftaranggota.store', 'daftaranggota.show'];
            foreach ($pembinaPermissions as $permission) {
                $pembinaRole->givePermissionTo($permission);
            }
        }
    }

    private function createKetuaUsers()
    {
        $this->createKetuaUser(2, 'Aden Muhammad Noor', 'aden@gmail.com', 'password', '220037', 'Aden Muhammad Noor', 'Mranggen, Demak', 'L', '0895340452388');
        $this->createKetuaUser(3, 'Aisya Khosyi', 'aisya@gmail.com', 'password', '220002', 'Aisya Khosyi', 'Bonang, Demak', 'P', '081225011289');
        $this->createKetuaUser(4, 'Ahmad Nabil Jafari', 'ahmad@gmail.com', 'password', '220039', 'Ahmad Nabil Jafari', 'Mranggen, Demak', 'L', '0851789245098');
        $this->createKetuaUser(5, 'Bagus Adlim Aqil', 'bagus@gmail.com', 'password', '220044', 'Bagus Adlim Aqil', 'Cangkring, Demak', 'L', '0891783594621');
        $this->createKetuaUser(6, 'Zidni Azizati', 'zidni@gmail.com', 'password', '220036', 'Zidni Azizati', 'Karanganyar, Demak', 'P', '082150890697');
        $this->createKetuaUser(7, 'Shofa Ilyana', 'shofa@gmail.com', 'password', '220069', 'Shofa Ilyana', 'Karangtengah, Demak', 'P', '082150890530'); // Perbaikan jenis kelamin
    }

    private function createKetuaUser($userId, $name, $email, $password, $nis, $nama, $alamat, $jk, $noHp)
    {
        $ketuaRole = Role::where('name', 'Ketua')->first();

        if ($ketuaRole) {
            if (!User::where('email', $email)->exists()) {
                // Create the user
                $ketuaUser = User::create([
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Assign role to the user
                $ketuaUser->assignRole($ketuaRole);

                // Insert into ketua table
                DB::table('ketua')->insert([
                    'id_ketua' => $userId,
                    'user_id' => $ketuaUser->id,
                    // 'ekstrakurikuler_id' => $ekstrakurikulerId, // Uncomment if needed
                    'nama' => $nama,
                    'nis' => $nis,
                    'alamat' => $alamat,
                    'jk' => $jk,
                    'no_hp' => $noHp,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                echo "User with email '{$email}' already exists.\n";
            }
        } else {
            echo "Role 'Ketua' does not exist.\n";
        }
    }

    // private function createPembinaUsers()
    // {
    //     // $this->createPembinaUser(8, 'Mohamad Taufiq', 'taufiq@gmail.com', 'password', '220037', 'Mohamad Taufiq', '197012311234567890', 'Sayung, Demak', 'L', '08819555831');
    //     // $this->createPembinaUser(9, 'Anik Hudayati', 'anik@gmail.com', 'password', '220002', 'Anik Hudayati', '196904122345678901', 'Cangkring, Demak', 'P', '0857555754');
    //     // $this->createPembinaUser(10, 'Himmatul Aliyah', 'himmatul@gmail.com', 'password', '220039', 'Himmatul Aliyah', '197511233456789012', 'Kadilangu, Demak', 'P', '082853555291');
    //     // $this->createPembinaUser(11, 'Nanik Esti Wulandari', 'nanik@gmail.com', 'password', '220044', 'Nanik Esti Wulandari', '197308154567890123', 'Tempuran, Demak', 'P', '08899555856');
    //     // $this->createPembinaUser(12, 'Mudrikatul Khoiriyah', 'mudrik@gmail.com', 'password', '220036', 'Mudrikatul Khoiriyah', '197611085678901234', 'Karanganyar, Demak', 'P', '08814555544');
    //     // $this->createPembinaUser(13, 'Ahmad Lujito', 'lujito@gmail.com', 'password', '220069', 'Ahmad Lujito', '196811306789012345', 'Guntur, Demak', 'L', '08818555825');
    //     // $this->createPembinaUser(14, 'Wahid Anwar', 'wahid@gmail.com', 'password', '220069', 'Wahid Anwar', '197204277890123456', 'Genuk, Semarang', 'L', '0896555160');
    // }

    // private function createPembinaUser($userId, $name, $email, $password, $ekstrakurikulerId, $nama, $nip, $alamat, $jk, $noHp)
    // {
    //     $pembinaRole = Role::where('name', 'Pembina')->first();

    //     if ($pembinaRole) {
    //         if (!User::where('email', $email)->exists()) {
    //             $pembinaUser = User::create([
    //                 'id' => $userId,
    //                 'name' => $name,
    //                 'email' => $email,
    //                 'password' => Hash::make($password),
    //                 'remember_token' => null,
    //                 'created_at' => Carbon::now(),
    //                 'updated_at' => Carbon::now(),
    //             ]);

    //             $pembinaUser->assignRole($pembinaRole);

    //             // Insert into pembina table
    //             DB::table('pembina')->insert([
    //                 'user_id' => $pembinaUser->id,
    //                 'nip' => $nip,
    //                 'nama' => $nama,
    //                 'alamat' => $alamat,
    //                 'jk' => $jk,
    //                 'no_hp' => $noHp,
    //                 'created_at' => Carbon::now(),
    //                 'updated_at' => Carbon::now(),
    //             ]);
    //         } else {
    //             echo "User with email '{$email}' already exists.\n";
    //         }
    //     } else {
    //         echo "Role 'Pembina' does not exist.\n";
    //     }
    // }

    private function createPembinaUsers()
    {
        $this->createPembinaUser(8, 'Mohamad Taufiq', 'taufiq@gmail.com', 'password', '197012311234567890', 'Mohamad Taufiq', 'Sayung, Demak', 'L', '08819555831');
        $this->createPembinaUser(9, 'Anik Hudayati', 'anik@gmail.com', 'password', '196904122345678901', 'Anik Hudayati', 'Cangkring, Demak', 'P', '0857555754');
        $this->createPembinaUser(10, 'Himmatul Aliyah', 'himmatul@gmail.com', 'password', '197511233456789012', 'Himmatul Aliyah', 'Kadilangu, Demak', 'P', '082853555291');
        $this->createPembinaUser(11, 'Nanik Esti Wulandari', 'nanik@gmail.com', 'password', '197308154567890123', 'Nanik Esti Wulandari', 'Tempuran, Demak', 'P', '08899555856');
        $this->createPembinaUser(12, 'Mudrikatul Khoiriyah', 'mudrik@gmail.com', 'password', '197611085678901234', 'Mudrikatul Khoiriyah', 'Karanganyar, Demak', 'P', '08814555544');
        $this->createPembinaUser(13, 'Ahmad Lujito', 'lujito@gmail.com', 'password', '196811306789012345', 'Ahmad Lujito', 'Guntur, Demak', 'L', '08818555825');
        $this->createPembinaUser(14, 'Wahid Anwar', 'wahid@gmail.com', 'password', '197204277890123456', 'Wahid Anwar', 'Genuk, Semarang', 'L', '0896555160');
    }

    private function createPembinaUser($userId, $name, $email, $password, $nip, $nama, $alamat, $jk, $noHp)
    {
        $pembinaRole = Role::where('name', 'Pembina')->first();

        if ($pembinaRole) {
            if (!User::where('email', $email)->exists()) {
                $pembinaUser = User::create([
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $pembinaUser->assignRole($pembinaRole);

                // Insert into pembina table
                DB::table('pembina')->insert([
                    'id_pembina' => $userId,
                    'user_id' => $pembinaUser->id,
                    'nip' => $nip,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'jk' => $jk,
                    'no_hp' => $noHp,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                echo "User with email '{$email}' already exists.\n";
            }
        } else {
            echo "Role 'Pembina' does not exist.\n";
        }
    }


    private function insertEkstrakurikuler()
    {
        // Make sure ketua_id exists before inserting
        $validKetuaIds = DB::table('ketua')->pluck('id_ketua')->toArray();

        $ekstrakurikulerData = [
            [
                'id_ekstrakurikuler' => 1,
                'nama' => 'Paskibra',
                'deskripsi' => 'Pasukan Pengibar Bendera',
                'ketua_id' => $validKetuaIds[0] ?? null, // Ensure valid ketua_id or set to null if not available
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_ekstrakurikuler' => 2,
                'nama' => 'Pramuka',
                'deskripsi' => 'Praja Muda Karana',
                'ketua_id' => $validKetuaIds[1] ?? null, // Ensure valid ketua_id or set to null if not available
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more entries as needed
        ];

        foreach ($ekstrakurikulerData as $data) {
            if (DB::table('ekstrakurikuler')->where('id_ekstrakurikuler', $data['id_ekstrakurikuler'])->doesntExist()) {
                DB::table('ekstrakurikuler')->insert($data);
            } else {
                echo "Ekstrakurikuler with ID '{$data['id_ekstrakurikuler']}' already exists.\n";
            }
        }
    }

    private function insertJadwalEkstrakurikuler()
    {
        // Make sure ekstrakurikuler_id exists before inserting
        $validEkstrakurikulerIds = DB::table('ekstrakurikuler')->pluck('id_ekstrakurikuler')->toArray();

        $jadwalEkstrakurikulerData = [
            [
                'id_jadwal_ekstrakurikuler' => 1,
                'ekstrakurikuler_id' => $validEkstrakurikulerIds[0] ?? null, // Ensure valid ekstrakurikuler_id or set to null if not available
                'hari' => 'Senin',
                'waktu' => '15:00',
                'lokasi' => 'lapangan utama',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_jadwal_ekstrakurikuler' => 2,
                'ekstrakurikuler_id' => $validEkstrakurikulerIds[1] ?? null, // Ensure valid ekstrakurikuler_id or set to null if not available
                'hari' => 'Selasa',
                'waktu' => '15:00',
                'lokasi' => 'ruang kelas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_jadwal_ekstrakurikuler' => 3,
                'ekstrakurikuler_id' => $validEkstrakurikulerIds[2] ?? null, // Ensure valid ekstrakurikuler_id or set to null if not available
                'hari' => 'Rabu',
                'waktu' => '15:00',
                'lokasi' => 'lapangan kedua',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($jadwalEkstrakurikulerData as $data) {
            if (DB::table('jadwal_ekstrakurikuler')->where('id_jadwal_ekstrakurikuler', $data['id_jadwal_ekstrakurikuler'])->doesntExist()) {
                DB::table('jadwal_ekstrakurikuler')->insert($data);
            } else {
                echo "Jadwal Ekstrakurikuler with ID '{$data['id_jadwal_ekstrakurikuler']}' already exists.\n";
            }
        }
    }
}
