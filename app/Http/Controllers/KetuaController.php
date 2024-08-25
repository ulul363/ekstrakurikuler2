<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ketua;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class KetuaController extends Controller
{
    public function index()
    {
        $ketua = Ketua::with('user')->get(); // Hanya mengambil data dari model User
        return view('ketua.index', compact('ketua'));
    }


    public function createUser()
    {
        $user = new User();
        return view('ketua.createuser', compact('user'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = Role::where('name', 'Ketua')->first();
        $user->assignRole($role);
        $user->syncPermissions($role->permissions);

        $request->session()->put('id_user', $user->id);
        $request->session()->put('user_name', $user->name);

        return redirect()->route('ketua.create');
    }

    public function create(Request $request)
    {
        $id_user = $request->session()->get('id_user');
        $user_name = $request->session()->get('user_name');
        $ekstrakurikuler = Ekstrakurikuler::all();

        return view('ketua.create', compact('id_user', 'user_name', 'ekstrakurikuler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nis' => 'required|string|max:20|unique:ketua',
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'jk' => 'required|in:L,P',
            'no_hp' => 'required|string|max:15',
        ]);

        Ketua::create([
            'user_id' => $validated['user_id'],
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'jk' => $validated['jk'],
            'no_hp' => $validated['no_hp'],
        ]);

        return redirect()->route('ketua.index')->with('success', 'Ketua berhasil dibuat.');
    }


    public function show(Ketua $ketua)
    {
        return view('ketua.show', compact('ketua'));
    }

    public function edit($id)
    {
        $ketua = Ketua::with('user', 'ekstrakurikuler')->findOrFail($id);
        $ekstrakurikuler = Ekstrakurikuler::all();
        return view('ketua.edit', compact('ketua', 'ekstrakurikuler'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'ekstrakurikuler_id' => ['required', 'exists:ekstrakurikuler,id_ekstrakurikuler', Rule::unique('ketua')->ignore($id, 'id_ketua')],
            'nis' => 'required|string|max:20|unique:ketua,nis,' . $id . ',id_ketua',
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'jk' => 'required|in:L,P',
            'no_hp' => 'required|string|max:15',
        ]);

        $ketua = Ketua::findOrFail($id);
        $ketua->update($validated);

        return redirect()->route('ketua.index')->with('success', 'Data ketua berhasil diperbarui.');
    }

    public function updateUser(Request $request, $user_id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($user_id);
        $user->password = Hash::make($validated['password']);
        $user->save();

        $ketua = Ketua::where('user_id', $user_id)->first();
        return redirect()
            ->route('ketua.edit', $ketua->id_ketua)
            ->with('success', 'Password user berhasil direset.');
    }

    public function destroy($id)
    {
        try {
            $ketua = Ketua::findOrFail($id);
            $user = User::findOrFail($ketua->user_id);

            $ketua->delete();
            $user->delete();

            return redirect()->route('ketua.index')->with('success', 'Data ketua dan akun pengguna berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('ketua.index')->with('error', 'Ketua tidak dapat dihapus karena sudah digunakan di tabel lain.');
            }

            return redirect()->route('ketua.index')->with('error', 'Terjadi kesalahan saat menghapus ketua.');
        }
    }

    public function status(Request $request, $id)
    {
        $ketua = Ketua::findOrFail($id);
        // dd($request->status);
        $ketua->status = $request->status;
        $ketua->save();

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }
}
