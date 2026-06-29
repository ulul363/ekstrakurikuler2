<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ketua;
use App\Models\Pembina;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::with(['pembina', 'ketua'])->get();
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
        $request->validate([
            'nama' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:200',
            'ketua_nama' => 'required|string',
            'ketua_nis' => 'required|string|max:20|unique:ketua,nis', // Perbaikan: size:6 diubah ke max:20 sesuai migration
            'ketua_email' => 'required|email|unique:users,email',
            'pembina_nama.*' => 'required|string',
            'pembina_nip.*' => 'required|string|max:18|unique:pembina,nip',
            'pembina_email.*' => 'required|email|unique:users,email',
        ]);

        DB::transaction(function () use ($request) {
            // USER KETUA
            $userKetua = User::create([
                'name' => $request->ketua_nama,
                'email' => $request->ketua_email,
                'password' => Hash::make('password'),
            ]);
            $userKetua->assignRole('Ketua');

            // EKSKUL
            $ekskul = Ekstrakurikuler::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            // KETUA
            Ketua::create([
                'user_id' => $userKetua->id,
                'nis' => $request->ketua_nis,
                'nama' => $request->ketua_nama,
                'ekstrakurikuler_id' => $ekskul->id_ekstrakurikuler, // Perbaikan key utama
                'status' => true,
            ]);

            // PEMBINA
            foreach ($request->pembina_nip as $i => $nip) {
                $userPembina = User::create([
                    'name' => $request->pembina_nama[$i],
                    'email' => $request->pembina_email[$i],
                    'password' => Hash::make('password'),
                ]);

                $userPembina->assignRole('Pembina');

                Pembina::create([
                    'user_id' => $userPembina->id,
                    'nip' => $nip,
                    'nama' => $request->pembina_nama[$i],
                    'ekstrakurikuler_id' => $ekskul->id_ekstrakurikuler, // Perbaikan key utama
                    'status' => true,
                ]);
            }
        });

        return redirect()->route('ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:200',
        ]);

        $ekskul->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        if (
            $ekskul->kehadiran()->exists() ||
            $ekskul->prestasi()->exists() ||
            $ekskul->programKegiatan()->exists() ||
            $ekskul->jadwal()->exists() ||
            $ekskul->daftarAnggota()->exists()
        ) {
            return back()->with('error', 'Masih ada data terkait.');
        }

        DB::transaction(function () use ($ekskul) {
            foreach ($ekskul->pembina as $pembina) {
                $pembina->user?->delete();
            }
            if ($ekskul->ketua) {
                $ekskul->ketua->user?->delete();
            }
            $ekskul->delete();
        });

        return redirect()
            ->route('ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}