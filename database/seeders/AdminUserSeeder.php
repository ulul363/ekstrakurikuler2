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

class AdminUserSeeder extends Seeder
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

        // Step 4: Insert Ekstrakurikuler
        $this->insertEkstrakurikuler();

        // Step 5: Insert Jadwal Ekstrakurikuler
        $this->insertJadwalEkstrakurikuler();

        // Step 6: Create Ketua Users
        $this->createKetuaUsers();

        // Step 7: Create Pembina Users
        $this->createPembinaUsers();
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
            $ketuaPermissions = ['dashboard', 'program_kegiatan.index', 'program_kegiatan.create', 'program_kegiatan.store', 'program_kegiatan.edit', 'program_kegiatan.update', 'program_kegiatan.destroy', 'program_kegiatan.show', 'kehadiran.index', 'kehadiran.create', 'kehadiran.store', 'kehadiran.edit', 'kehadiran.update', 'kehadiran.destroy', 'kehadiran.show', 'prestasi.index', 'prestasi.create', 'prestasi.store', 'prestasi.edit', 'prestasi.update', 'prestasi.destroy', 'prestasi.show'];
            foreach ($ketuaPermissions as $permission) {
                $ketuaRole->givePermissionTo($permission);
            }
        }

        // Create Pembina Role
        if (!Role::where('name', 'Pembina')->exists()) {
            $pembinaRole = Role::create(['name' => 'Pembina']);
            $pembinaPermissions = ['dashboard', 'program_kegiatan.index', 'program_kegiatan.store', 'program_kegiatan.show', 'program_kegiatan.verifikasi', 'kehadiran.index', 'kehadiran.store', 'kehadiran.show', 'kehadiran.verifikasi', 'prestasi.index', 'prestasi.store', 'prestasi.show', 'prestasi.verifikasi'];
            foreach ($pembinaPermissions as $permission) {
                $pembinaRole->givePermissionTo($permission);
            }
        }
    }

    private function insertEkstrakurikuler()
    {
        DB::table('ekstrakurikuler')->insert([['id_ekstrakurikuler' => 1, 'nama' => 'Pramuka', 'deskripsi' => 'Ekstrakurikuler Pramuka', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], ['id_ekstrakurikuler' => 2, 'nama' => 'Fotografi', 'deskripsi' => 'Ekstrakurikuler Fotografi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]]);
    }

    private function insertJadwalEkstrakurikuler()
    {
        DB::table('jadwal_ekstrakurikuler')->insert([['id_jadwal_ekstrakurikuler' => 1, 'ekstrakurikuler_id' => 1, 'hari' => 'Jumat', 'waktu' => '16:00:00', 'lokasi' => 'Lapangan Utama', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], ['id_jadwal_ekstrakurikuler' => 2, 'ekstrakurikuler_id' => 2, 'hari' => 'Senin', 'waktu' => '15:00:00', 'lokasi' => 'Ruang Kelas XII MIPA 4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]]);
    }

    private function createKetuaUsers()
    {
        $this->createKetuaUser(2, 'Ulul Azmi', 'ulul@gmail.com', 'password', 1, '210102014', 'Ulul Azmi', 'Mranggen, Demak', 'L', '0895340452388');

        $this->createKetuaUser(3, 'Kukuh Mudhaya', 'kukuh@gmail.com', 'password', 2, '210102001', 'Kukuh Mudhaya', 'Wangon, Banyumas', 'L', '081225011289');
    }

    private function createKetuaUser($userId, $name, $email, $password, $ekstrakurikulerId, $nis, $nama, $alamat, $jk, $noHp)
    {
        $ketuaRole = Role::where('name', 'Ketua')->first();

        if ($ketuaRole) {
            if (!User::where('email', $email)->exists()) {
                $ketuaUser = User::create([
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $ketuaUser->assignRole($ketuaRole);

                DB::table('ketua')->insert([
                    'id_ketua' => $userId,
                    'user_id' => $ketuaUser->id,
                    'ekstrakurikuler_id' => $ekstrakurikulerId,
                    'nama' => $nama,
                    'nis' => $nis,
                    'alamat' => $alamat,
                    'jk' => $jk,
                    'no_hp' => $noHp,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                echo "User with email '{$email}' already exists.";
            }
        } else {
            echo "Role 'Ketua' does not exist.";
        }
    }

    private function createPembinaUsers()
    {
        $this->createPembinaUser(4, 'Dwiyana', 'dwiyana@gmail.com', 'password', 1, 'Dwiyana', '1987210722201', 'Sidanegara, Cilacap', 'L', '081335011279');

        $this->createPembinaUser(5, 'Lando Archivilando', 'lando@gmail.com', 'password', 2, 'Lando Archivilando', '1987210722063', 'Solo, Jawa Tengah', 'L', '081225044123');
        $this->createPembinaUser(6, 'Ipo Novianto', 'ipo@gmail.com', 'password', 2, 'Ipo Novianto', '19872107210781', 'Kawunganten, Cilacap', 'L', '081226011298');
    }

    private function createPembinaUser($userId, $name, $email, $password, $ekstrakurikulerId, $nama, $nip, $alamat, $jk, $noHp)
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
                    'ekstrakurikuler_id' => $ekstrakurikulerId,
                    'nama' => $nama,
                    'nip' => $nip,
                    'alamat' => $alamat,
                    'jk' => $jk,
                    'no_hp' => $noHp,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                echo "User with email '{$email}' already exists.";
            }
        } else {
            echo "Role 'Pembina' does not exist.";
        }
    }
}
