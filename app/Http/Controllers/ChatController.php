<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $authId = auth()->id();
        // Ambil semua user kecuali diri sendiri
        $users = User::where('id', '!=', $authId)->get();
        return view('chat.index', compact('users'));
    }

    public function show($receiverId)
    {
        $authId = auth()->id();
        $receiver = User::findOrFail($receiverId);

        $messages = Chat::where(function ($query) use ($authId, $receiverId) {
            $query->where('pengirim_id', $authId)->where('penerima_id', $receiverId);
        })->orWhere(function ($query) use ($authId, $receiverId) {
            $query->where('pengirim_id', $receiverId)->where('penerima_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        Chat::where('pengirim_id', $receiverId)->where('penerima_id', $authId)->update(['is_read' => true]);

        return view('chat.show', compact('messages', 'receiver'));
    }

    public function store(Request $request)
    {
        // Validasi disamakan dengan nama input di Blade
        $request->validate([
            'receiver_id' => 'required',
            'pesan' => 'required|string'
        ]);

        Chat::create([
            'pengirim_id' => auth()->id(),
            'penerima_id' => $request->receiver_id,
            'pesan' => $request->pesan,
            'is_read' => false
        ]);

        // Karena dikirim lewat AJAX, kembalikan JSON
        return response()->json(['status' => 'success', 'message' => 'Pesan terkirim']);
    }
}