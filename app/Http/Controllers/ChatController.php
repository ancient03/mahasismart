<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function showUserChat(Request $request, $toko_id)
    {
        $toko = Toko::findOrFail($toko_id);
        $user = Auth::user();
        $messages = Message::where('toko_id', $toko_id)
                            ->where(function($query) use ($user) {
                                $query->where('sender_id', $user->id)
                                      ->orWhere('receiver_id', $user->id);
                            })
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('page.chat', compact('toko', 'messages'));
    }

    public function showTokoChat(Request $request)
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->back()->with('error', 'Anda tidak memiliki toko.');
        }

        $conversations = Message::where('toko_id', $toko->id)
                                ->select('sender_id', 'receiver_id')
                                ->groupBy('sender_id', 'receiver_id')
                                ->get();
        
        $users = [];
        foreach ($conversations as $conversation) {
            $userId = $conversation->sender_id == Auth::id() ? $conversation->receiver_id : $conversation->sender_id;
            if(!in_array($userId, array_map(function($user) { return $user->id; }, $users))) {
                $user = User::find($userId);
                if($user) {
                    $users[] = $user;
                }
            }
        }

        return view('toko.chat', compact('toko', 'users'));
    }

    public function showTokoConversation(Request $request, $user_id)
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->back()->with('error', 'Anda tidak memiliki toko.');
        }

        $user = User::findOrFail($user_id);

        $messages = Message::where('toko_id', $toko->id)
                            ->where(function($query) use ($user_id) {
                                $query->where('sender_id', $user_id)
                                      ->orWhere('receiver_id', $user_id);
                            })
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('toko.conversation', compact('toko', 'user', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:toko,id_toko',
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'toko_id' => $request->toko_id,
            'message' => $request->message,
        ]);

        return back();
    }
}