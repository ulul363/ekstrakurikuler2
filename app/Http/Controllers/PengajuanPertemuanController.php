<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ketua;
use App\Models\Pembina;
use Illuminate\Http\Request;
use App\Models\PengajuanPertemuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanPertemuanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;

            if (!$pembina) {
                abort(403, 'Pembina data not found.');
            }

            $pertemuan = PengajuanPertemuan::with('ketua')
                ->where('pembina_id', $pembina->id_pembina)
                ->get();
        } else {
            $ketuaId = $user->ketua->id_ketua;
            $pertemuan = PengajuanPertemuan::with('ketua')->where('ketua_id', $ketuaId)->get();
        }

        return view('pertemuan.index', compact('pertemuan'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $pengajuanPertemuan = PengajuanPertemuan::findOrFail($id);
        $pengajuanPertemuan->status = $request->status;
        $pengajuanPertemuan->keterangan = $request->keterangan;
        $pengajuanPertemuan->verifikasi_id = auth()->user()->pembina->id_pembina ?? null;
        $pengajuanPertemuan->waktu_verifikasi = now();
        $pengajuanPertemuan->save();

        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil diverifikasi.');
    }

    public function create()
    {
        if (!Auth::user()->ketua) {
            return redirect()->route('pertemuan.index')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }

        $ekstrakurikuler_id = Auth::user()->ketua->ekstrakurikuler_id;
        $pembina = Pembina::where('ekstrakurikuler_id', $ekstrakurikuler_id)->get();

        if ($pembina->isEmpty()) {
            return redirect()->route('pertemuan.index')->withErrors('Tidak ada pembina yang ditemukan untuk ekstrakurikuler ini.');
        }

        return view('pertemuan.create', compact('pembina'));
    }

    public function store(Request $request)
    {
        // Validasi input dengan validasi kustom untuk tanggal
        $validator = Validator::make($request->all(), [
            'pembina_id' => 'required|exists:pembina,id_pembina',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Tanggal harus setidaknya satu hari ke depan
                    if (strtotime($value) <= strtotime('tomorrow')) {
                        $fail('Tanggal pertemuan harus setidaknya satu hari ke depan.');
                    }
                },
            ],
            'waktu' => 'required|date_format:H:i',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->route('pertemuan.create')->withErrors($validator)->withInput();
        }

        // Memeriksa apakah pengguna yang login memiliki data ketua yang valid
        if (!Auth::user()->ketua) {
            return redirect()->route('pertemuan.index')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }

        // Mendapatkan id_ketua dari pengguna yang sedang login
        $ketua_id = Auth::user()->ketua->id_ketua;

        // Membuat pengajuan pertemuan baru
        PengajuanPertemuan::create([
            'ketua_id' => $ketua_id,
            'pembina_id' => $request->pembina_id,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => 'pending',
        ]);

        // Redirect ke halaman pertemuan index dengan pesan sukses
        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil diajukan.');
    }

    public function edit($id)
    {
        $pertemuan = PengajuanPertemuan::findOrFail($id);
        return view('pertemuan.edit', compact('pertemuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dengan validasi kustom untuk tanggal
        $validator = Validator::make($request->all(), [
            'pembina_id' => 'required|exists:pembina,id_pembina',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Tanggal harus setidaknya satu hari ke depan
                    if (strtotime($value) <= strtotime('tomorrow')) {
                        $fail('Tanggal pertemuan harus setidaknya satu hari ke depan.');
                    }
                },
            ],
            'waktu' => 'required|date_format:H:i',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()
                ->route('pertemuan.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        // Menampilkan pengajuan pertemuan berdasarkan ID
        $pengajuan = PengajuanPertemuan::findOrFail($id);

        // Memeriksa apakah pengguna yang login memiliki data ketua yang valid
        if (!Auth::user()->ketua) {
            return redirect()->route('pertemuan.index')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }

        // Memperbarui data pengajuan pertemuan
        $pengajuan->update([
            'pembina_id' => $request->pembina_id,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
        ]);

        // Redirect ke halaman pertemuan index dengan pesan sukses
        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pertemuan = PengajuanPertemuan::findOrFail($id);
        $pertemuan->delete();
        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil dihapus.');
    }

    public function show($id)
    {
        $pertemuan = PengajuanPertemuan::with('ketua', 'pembina')->findOrFail($id);
        return response()->json($pertemuan);
    }
}
