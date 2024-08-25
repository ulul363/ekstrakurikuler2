<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat peran
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $pembinaRole = Role::firstOrCreate(['name' => 'pembina']);
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);

        // Membuat izin admin
        $adminPermissions = [
            'manage users',
            'manage siswa',
            'manage pembina',
            'manage ekstrakurikuler',
            'manage program kegiatan',
            'manage kehadiran',
            'manage jadwal ekstrakurikuler',
            'manage prestasi ekstrakurikuler',
            'manage prestasi peserta',
            'chat with pembina'
        ];

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        // Membuat izin untuk pembina
        $pembinaPermissions = [
            'review program kegiatan',
            'review kehadiran',
            'view jadwal ekstrakurikuler',
            'view/review prestasi ekstrakurikuler',
            'review prestasi peserta',
            'chat with siswa',
            'review pertemuan'
        ];

        foreach ($pembinaPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $pembinaRole->givePermissionTo($permission);
        }

        // Membuat izin untuk siswa
        $siswaPermissions = [
            'view ekstrakurikuler',
            'add/view program kegiatan',
            'add/view berkas kehadiran',
            'view jadwal ekstrakurikuler',
            'add/view prestasi ekstrakurikuler',
            'add/view prestasi siswa',
            'request pertemuan',
            'chat with pembina'
        ];

        foreach ($siswaPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $siswaRole->givePermissionTo($permission);
        }

        // Membuat pengguna
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $pembina = User::firstOrCreate(
            ['email' => 'pembina@gmail.com'],
            [
                'name' => 'Pembina',
                'password' => Hash::make('12345678'),
            ]
        );

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Siswa',
                'password' => Hash::make('12345678'),
            ]
        );

        // Menetapkan peran ke pengguna
        $admin->assignRole('admin');
        $pembina->assignRole('pembina');
        $siswa->assignRole('siswa');
    }
}
