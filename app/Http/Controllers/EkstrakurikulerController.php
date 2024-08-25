<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ketua;
use App\Models\Pembina;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Hash;
use App\Models\EkstrakurikulerPembina;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        // $ekstrakurikulerpembinas = EkstrakurikulerPembina::with('ekstrakurikuler.ketua', 'pembina')->get();
        $ekstrakurikuler = Ekstrakurikuler::with('pembina', 'ketua')->get();
        return view('ekstrakurikuler.index2', compact('ekstrakurikuler'));
    }

    public function create()
    {
        $ketua = Ketua::all();
        $pembina = Pembina::all();
        return view('ekstrakurikuler.create', compact('ketua', 'pembina'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:200',
            'ketua_nama' => 'required|string',
            'ketua_nis' => 'required|string|size:6|unique:ketua,nis',
            'pembina_nama.*' => 'required|string',
            'pembina_nip.*' => 'required|string|size:18|unique:pembina,nip',
            'pembina_email.*' => 'required|email|unique:users,email', // Tambahkan validasi email unik
        ]);

        // Buat akun pengguna untuk Ketua
        $userKetua = User::create([
            'name' => $request->ketua_nama,
            'email' => $request->ketua_email,
            'password' => Hash::make('password'),
        ]);
        $userKetua->assignRole('Ketua');

        // Buat ekstrakurikuler
        $ekstrakurikuler = Ekstrakurikuler::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        // Buat Ketua
        Ketua::create([
            'user_id' => $userKetua->id,
            'nis' => $request->ketua_nis,
            'nama' => $request->ketua_nama,
            'ekstrakurikuler_id' => $ekstrakurikuler->id_ekstrakurikuler,
            'status' => true,
        ]);

        // Buat Pembina (bisa lebih dari satu)
        foreach ($request->pembina_nip as $index => $nip) {
            $pembinaNama = $request->pembina_nama[$index];
            $userPembina = User::create([
                'name' => $pembinaNama,
                'email' => $request->pembina_email[$index],
                'password' => Hash::make('password'),
            ]);
            $userPembina->assignRole('Pembina');
            // dd($pembinaNama);

            Pembina::create([
                'user_id' => $userPembina->id,
                'nip' => $request->pembina_nip[$index],
                'nama' => $request->pembina_nama[$index],
                'ekstrakurikuler_id' => $ekstrakurikuler->id_ekstrakurikuler,
                'status' => true,
            ]);
        }

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dibuat.');
    }

    public function edit($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ketua = Ketua::where('status', 1)->get();
        // dd($ketua);
        $pembina = Pembina::all();
        // dd($ekstrakurikuler, $ketua, $pembina);
        return view('ekstrakurikuler.edit', compact('ekstrakurikuler', 'ketua', 'pembina'));
    }

    public function update(Request $request, $id)
    {
        dd($request);
        $request->validate([
            'nama' => 'required|string|max:20',
            'deskripsi' => 'nullable|string|max:200',
            // 'ketua_id' => 'required|exists:ketua,id_ketua',
            // 'pembina_ids' => 'required|array',
            // 'pembina_ids.*' => 'exists:pembina,id_pembina',
        ]);
        // dd($request);

        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        
        // dd($request->all(), $ekstrakurikuler);
        // $ketua = Ketua::where('nis', $request->ketua_nis)->first();
        // dd($ketua->user_id);
        // $ketua->nama = $request->ketua_nama;
        // $ketua->nis = $request->ketua_nis;
        // $ketua->save();

        // $user = User::findOrFail($ketua->user_id);
        // $user->name = $request->ketua_nama;
        // $user->save();

        // Periksa apakah ketua sudah ada di ekstrakurikuler lain
        if (Ekstrakurikuler::where('ketua_id', $request->ketua_id)->where('id_ekstrakurikuler', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Maaf, ketua sudah ada di ekstrakurikuler lain.');
        }
        dd($ekstrakurikuler);
        // Periksa apakah pembina sudah menjadi pembina di ekstrakurikuler lain
        foreach ($request->pembina_ids as $pembinaId) {
            if (Ekstrakurikuler::whereHas('pembina', function ($query) use ($pembinaId) {
                $query->where('pembina_id', $pembinaId);
            })->where('id_ekstrakurikuler', '!=', $id)->exists()) {
                return redirect()->back()->with('error', 'Maaf, salah satu pembina sudah menjadi pembina di ekstrakurikuler lain.');
            }
        }

        // Update Ekstrakurikuler
        $ekstrakurikuler->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ketua_id' => $request->ketua_id,
        ]);

        // Update relasi dengan Pembina
        $ekstrakurikuler->pembina()->sync($request->pembina_ids);
        // dd($ekstrakurikuler->fresh());

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

        // Periksa apakah ada ketua yang terkait
        if ($ekstrakurikuler->ketua) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Ekstrakurikuler ini karena masih terdapat Ketua yang terkait.');
        }

        // Hapus relasi dengan Pembina
        $ekstrakurikuler->pembina()->detach();

        // Hapus Ekstrakurikuler
        $ekstrakurikuler->delete();

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
