<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\ProgramKegiatan;
use Illuminate\Support\Facades\Auth;
use App\Models\EkstrakurikulerPembina;

class ProgramKegiatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Pembina')) {
            $pembina = $user->pembina;
            // dd($pembina);
            if (!$pembina) {
                abort(403, 'Pembina data not found.');
            }

            // $ekstrakurikulerId = $pembina->ekstrakurikuler_id;
            // $programKegiatan = ProgramKegiatan::with('ekstrakurikuler', 'ketua')
            //     ->whereHas('ekstrakurikuler', function ($query) use ($ekstrakurikulerId) {
            //         $query->where('id_ekstrakurikuler', $ekstrakurikulerId);
            //     })
            //     ->get();

            $programKegiatan = ProgramKegiatan::where('pembina_id', $pembina->id_pembina)->get();
            // dd($programkegiatan);

        } else {
            $ketuaId = $user->ketua->id_ketua;
            $programKegiatan = ProgramKegiatan::with('ekstrakurikuler', 'ketua', 'pembina')->where('ketua_id', $ketuaId)->get();
        }

        return view('program_kegiatan.index', compact('programKegiatan'));
    }

    public function verifikasi(Request $request, $id)
    {
        $programKegiatan = ProgramKegiatan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $programKegiatan->status = $request->input('status');
        $programKegiatan->keterangan = $request->keterangan;
        $programKegiatan->pembina_id = auth()->user()->pembina->id_pembina;
        $programKegiatan->save();

        return redirect()->route('program_kegiatan.index')->with('success', 'Program kegiatan berhasil diverifikasi.');
    }

    public function create()
    {
        return view('program_kegiatan.create');
    }

    public function store(Request $request)
    {
        $currentYear = date('Y');

        $request->validate([
            'nama_program' => 'required|string|max:50',
            'tahun_ajaran' => 'required|integer|in:' . $currentYear,
            'deskripsi' => 'required|string|max:200',
        ]);

        $user = Auth::user();

        if ($user->ketua) {
            $ekstrakurikuler = Ekstrakurikuler::where('ketua_id', $user->id)->first();

            if (!$ekstrakurikuler) {
                return redirect()->route('program_kegiatan.create')->withErrors('Ekstrakurikuler tidak ditemukan untuk ketua yang login.');
            }

            $pembina = EkstrakurikulerPembina::where('ekstrakurikuler_id', $ekstrakurikuler->id_ekstrakurikuler)->first();

            if (!$pembina) {
                return redirect()->route('program_kegiatan.create')->withErrors('Pembina tidak ditemukan untuk ekstrakurikuler yang dipilih.');
            }

            $ketua_id = $user->ketua->id_ketua;

            ProgramKegiatan::create([
                'ekstrakurikuler_id' => $ekstrakurikuler->id_ekstrakurikuler,
                'ketua_id' => $ketua_id,
                'pembina_id' => $pembina->pembina_id,
                'nama_program' => $request->nama_program,
                'tahun_ajaran' => $request->tahun_ajaran,
                'deskripsi' => $request->deskripsi,
                'status' => 'pending',
            ]);

            return redirect()->route('program_kegiatan.index')->with('success', 'Program Kegiatan berhasil diajukan.');
        } else {
            return redirect()->route('program_kegiatan.create')->withErrors('Pengguna yang login tidak memiliki data ketua yang valid.');
        }
    }

    public function edit($id)
    {
        $programKegiatan = ProgramKegiatan::findOrFail($id);
        return view('program_kegiatan.edit', compact('programKegiatan'));
    }

    public function update(Request $request, $id)
    {
        $currentYear = date('Y');

        $request->validate([
            'nama_program' => 'required|string|max:50',
            'tahun_ajaran' => 'required|integer|in:' . $currentYear,
            'deskripsi' => 'required|string|max:200',
        ]);

        $programKegiatan = ProgramKegiatan::findOrFail($id);
        $programKegiatan->update($request->all());

        return redirect()->route('program_kegiatan.index')->with('success', 'Program Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $programKegiatan = ProgramKegiatan::findOrFail($id);
        $programKegiatan->delete();

        return redirect()->route('program_kegiatan.index')->with('success', 'Program Kegiatan berhasil dihapus.');
    }

    public function show($id)
    {
        $programKegiatan = ProgramKegiatan::with('ekstrakurikuler', 'ketua', 'pembina')->findOrFail($id);
        return response()->json($programKegiatan);
    }
}
