<?php

namespace App\Http\Controllers;

use App\Models\DaftarAnggota;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;

            if (!$pembina) {
                abort(403, 'Pembina data not found.');
            }

            $ekstrakurikulerId = $pembina->ekstrakurikuler_id;
            $prestasis = Prestasi::with('ekstrakurikuler', 'ketua')
                ->whereHas('ekstrakurikuler', function ($query) use ($ekstrakurikulerId) {
                    $query->where('id_ekstrakurikuler', $ekstrakurikulerId);
                })
                ->get();
        } else {
            $ketuaId = $user->ketua->id_ketua;
            $prestasis = Prestasi::with('ekstrakurikuler', 'ketua', 'pembina')->where('ketua_id', $ketuaId)->get();
        }

        return view('prestasi.index', compact('prestasis'));
    }


    public function verifikasi(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $prestasi->status = $request->input('status');
        $prestasi->keterangan = $request->keterangan;
        $prestasi->pembina_id = auth()->user()->pembina->id_pembina;
        $prestasi->save();

        return redirect()->route('prestasi.index')->with('success', 'Kehadiran berhasil diverifikasi.');
    }

    public function create()
    {
        $user = Auth::user();
        $ekstrakurikulerId = $user->ketua->ekstrakurikuler_id;
        // dd($ekstrakurikulerId);

        // $daftaranggota = DaftarAnggota::all();
        $daftaranggota = DaftarAnggota::where('ekstrakurikuler_id', $ekstrakurikulerId)->get();
        // dd($daftaranggota);

        return view('prestasi.create', compact('daftaranggota'));
    }

    public function store(Request $request)
{
    $request->validate([
        'prestasi' => 'required|string|max:50',
        'nama_siswa' => 'required|array',
        'kelas' => 'required|array', // Pastikan untuk menambahkan validasi kelas
        'tahun_ajaran' => 'required|integer',
        'berkas' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $ekstrakurikuler_id = Auth::user()->ketua->ekstrakurikuler_id;
    $ketua_id = Auth::user()->ketua->id_ketua;

    $berkasPath = null;
    if ($request->hasFile('berkas')) {
        $berkas = $request->file('berkas');
        $fileName = time() . '_' . $berkas->getClientOriginalName();
        $berkasPath = $berkas->storeAs('uploads/prestasi', $fileName, 'public');
    }

    Prestasi::create([
        'prestasi' => $request->prestasi,
        'ekstrakurikuler_id' => $ekstrakurikuler_id,
        'ketua_id' => $ketua_id,
        'nama_siswa' => json_encode($request->nama_siswa),
        'kelas' => json_encode($request->kelas), // Pastikan ini menyimpan array kelas siswa
        'tahun_ajaran' => $request->tahun_ajaran,
        'berkas' => $berkasPath,
        'status' => 'pending',
    ]);

    return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
}


    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $nama_siswa = json_decode($prestasi->nama_siswa, true) ?? [];
        $kelas = json_decode($prestasi->kelas, true) ?? [];
        return view('prestasi.edit', compact('prestasi', 'nama_siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prestasi' => 'required|string|max:50',
            'nama_siswa.*' => 'required|string|max:50',
            'kelas.*' => 'required|string|max:5',
            'tahun_ajaran' => 'required|integer',
            'berkas' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $prestasi = Prestasi::findOrFail($id);

        // Pastikan pengguna yang login memiliki data ketua
        if (!Auth::user()->ketua) {
            return redirect()->route('prestasi.index')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }

        $prestasi->prestasi = $request->prestasi;
        $prestasi->nama_siswa = json_encode($request->nama_siswa);
        $prestasi->kelas = json_encode($request->kelas);
        $prestasi->tahun_ajaran = $request->tahun_ajaran;

        // Proses upload berkas jika ada
        if ($request->hasFile('berkas')) {
            // Hapus berkas lama jika ada
            if (Storage::disk('public')->exists($prestasi->berkas)) {
                Storage::disk('public')->delete($prestasi->berkas);
            }

            $fileName = time() . '_' . $request->file('berkas')->getClientOriginalName();
            $filePath = $request->file('berkas')->storeAs('uploads/prestasi', $fileName, 'public');
            $prestasi->berkas = $filePath;
        }

        $prestasi->save();

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        if (Storage::disk('public')->exists($prestasi->berkas)) {
            Storage::disk('public')->delete($prestasi->berkas);
        }
        $prestasi->delete();

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }

    public function show($id)
    {
        $prestasi = Prestasi::with('ekstrakurikuler', 'ketua', 'pembina')->findOrFail($id);
        return response()->json($prestasi);
    }
}
