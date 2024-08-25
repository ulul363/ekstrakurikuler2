<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PengajuanPertemuan;
use Spatie\Permission\Models\Role;

class ChatController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function fetch($id)
    {
        $chats = Chat::where('pengajuan_pertemuan_id', $id)->get();
        return response()->json($chats);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_pertemuan_id' => 'required|exists:pengajuan_pertemuan,id_pengajuan_pertemuan',
            'pesan' => 'required|string|max:255',
        ]);

        try {
            Chat::create([
                'pengajuan_pertemuan_id' => $request->pengajuan_pertemuan_id,
                'pengirim' => auth()->user()->id,
                'pesan' => $request->pesan,
            ]);

            // Return JSON response
            return response()->json(['message' => 'Yey Chat Terkirim']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }


    public function show($id)
    {
        $pertemuan = PengajuanPertemuan::findOrFail($id);
        $chats = Chat::where('pengajuan_pertemuan_id', $id)->get();

        // Contoh: Mendapatkan data Pembina dan Ketua berdasarkan peran (role)
        $pembina = User::role('Pembina')->first(); // Sesuaikan dengan logika bisnis Anda
        $ketua = User::role('Ketua')->first(); // Sesuaikan dengan logika bisnis Anda

        return view('chatroom.show', compact('pertemuan', 'chats', 'pembina', 'ketua'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    private function canChat($sender, $receiver)
    {
        if ($sender->hasRole('Ketua') && $receiver->hasRole('Pembina')) {
            return true;
        }

        if ($sender->hasRole('Pembina') && ($receiver->hasRole('Ketua') || $receiver->hasRole('Admin'))) {
            return true;
        }

        return false;
    }

    // public function getNewMessages($id)
    // {
    //     Log::info('Fetching new messages for meeting id: ' . $id);

    //     if (!auth()->check()) {
    //         Log::warning('User not authenticated');
    //         return response('Unauthorized', 401);
    //     }

    //     $chats = Chat::where('pengajuan_pertemuan_id', $id)
    //         ->where('created_at', '>', session('last_check', now()))
    //         ->get();

    //     session(['last_check' => now()]);

    //     Log::info('New messages fetched: ' . $chats->count());

    //     return view('chatroom.chat-messages-list', compact('chats'));
    // }

    public function getNewMessages($id)
    {
        if (!auth()->check()) {
            return response('Unauthorized', 401);
        }

        $chats = Chat::where('pengajuan_pertemuan_id', $id)
            ->where('created_at', '>', session('last_check', now()))
            ->get();

        session(['last_check' => now()]);

        return view('chatroom.chat-message-list', compact('chats'));
    }
}
