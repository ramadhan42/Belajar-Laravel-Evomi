<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Mengambil riwayat chat antara user yang sedang login dengan kontak (admin/user lain)
     */
    public function getMessages($contact_id)
    {
        $userId = Auth::id();

        // Ambil pesan di mana user login sebagai pengirim atau penerima terhadap kontak tersebut
        $messages = Chat::where(function ($query) use ($userId, $contact_id) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $contact_id);
        })->orWhere(function ($query) use ($userId, $contact_id) {
            $query->where('sender_id', $contact_id)
                ->where('receiver_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * Mengirim pesan baru
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => $chat,
        ], 201);
    }

    /**
     * Tandai pesan telah dibaca (Opsional)
     */
    public function markAsRead($sender_id)
    {
        Chat::where('sender_id', $sender_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan telah dibaca',
        ]);
    }

    // app/Http/Controllers/ChatController.php

    /**
     * Mengambil daftar user yang pernah melakukan chat dengan admin
     */
    public function getConversations()
    {
        $adminId = Auth::id();

        // Ambil user unik yang pernah mengirim pesan ke admin atau menerima pesan dari admin
        $users = Chat::where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($chat) use ($adminId) {
                // Jika pengirimnya admin, ambil data penerima. Jika pengirimnya user, ambil data pengirim.
                return $chat->sender_id == $adminId ? $chat->receiver : $chat->sender;
            })
            ->unique('id')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }
}
