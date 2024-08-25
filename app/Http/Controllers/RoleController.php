<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        $permissions = Permission::whereIn('id', $request->input('permission'))->get();
        $role->syncPermissions($permissions);

        return redirect()->route('role.index')->with('success', 'Role baru berhasil dibuat!');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('id')->all();
        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = $request->input('permission', []);
        $existingPermissions = $role->permissions->pluck('id')->toArray();
        $permissionsToAdd = array_diff($permissions, $existingPermissions);
        $permissionsToRemove = array_diff($existingPermissions, $permissions);

        foreach ($permissionsToAdd as $permissionId) {
            $permission = Permission::find($permissionId);
            $role->givePermissionTo($permission);
        }

        foreach ($permissionsToRemove as $permissionId) {
            $permission = Permission::find($permissionId);
            $role->revokePermissionTo($permission);
        }

        foreach ($role->users as $user) {
            $userPermissions = $user->permissions->pluck('id')->toArray();

            $userPermissionsToAdd = array_diff($permissions, $userPermissions);

            $userPermissionsToRemove = array_diff($userPermissions, $permissions);

            foreach ($userPermissionsToAdd as $permissionId) {
                $permission = Permission::find($permissionId);
                $user->givePermissionTo($permission);
            }

            foreach ($userPermissionsToRemove as $permissionId) {
                $permission = Permission::find($permissionId);
                $user->revokePermissionTo($permission);
            }
        }

        return redirect()->route('role.index')->with('success', 'Role berhasil diupdate dengan permission yang baru.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Admin') {
            return redirect()->route('role.index')->with('error', 'Role Admin tidak dapat dihapus.');
        }

        $usersWithRole = $role->users;
        if ($usersWithRole->isNotEmpty()) {
            return redirect()->route('role.index')->with('error', 'Tidak dapat menghapus role yang masih digunakan oleh pengguna.');
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus.');
    }

    public function getRoutesAllJson()
    {
        $routes = Route::getRoutes();

        $routeNames = [];
        foreach ($routes as $route) {
            $routeNames[] = $route->getName();
        }

        $existingRoutes = DB::table('permissions')->whereIn('name', $routeNames)->pluck('name')->toArray();

        $dataToInsert = [];

        foreach ($routes as $route) {
            $routeName = $route->getName();
            if ($routeName !== null && !Str::startsWith($routeName, ['password.', 'verification.', 'debugbar.', 'sanctum.', 'ignition.', 'profile.', 'login', 'logout', 'register', 'livewire.', 'cariAset'])) {
                if (!in_array($routeName, $existingRoutes)) {
                    $dataToInsert[] = [
                        'name' => $route->getName(),
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($dataToInsert)) {
            DB::table('permissions')->insert($dataToInsert);
            return redirect()->back()->with('success', 'Routes berhasil diperbarui!');
        } else {
            return redirect()->back()->with('success', 'Semua Routes sudah terdaftar.');
        }
    }

    public function getRefreshAndDeleteJson()
    {
        $routes = Route::getRoutes();
        $routeNames = collect($routes)->map(function ($route) {
            return $route->getName();
        })->filter(function ($name) {
            return $name !== null && !Str::startsWith($name, [
                'password.',
                'verification.',
                'debugbar.',
                'sanctum.',
                'ignition.',
                'profile.',
                'login',
                'logout',
                'register',
                'livewire.',
            ]);
        })->toArray();

        $permissions = DB::table('permissions')->pluck('name')->toArray();

        $permissionsToDelete = array_diff($permissions, $routeNames);

        if (!empty($permissionsToDelete)) {
            DB::table('permissions')->whereIn('name', $permissionsToDelete)->delete();
            return redirect()->back()->with('success', 'Permissions yang tidak terpakai berhasil dihapus.');
        } else {
            return redirect()->back()->with('success', 'Tidak ada permissions yang dihapus.');
        }
    }
}