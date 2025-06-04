<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getConversations(Request $request)
    {
        $user = Auth::user();
        $conversations = Conversation::where('guru_id', $user->idUser)
                                    ->orWhere('mentor_id', $user->idUser)
                                    ->with(['guru', 'mentor', 'lastMessage'])
                                    ->orderBy('last_message_at', 'desc')
                                    ->get();

        return response()->json($conversations);
    }

    public function getMessages(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::where(function ($query) use ($user) {
            $query->where('guru_id', $user->idUser)
                  ->orWhere('mentor_id', $user->idUser);
        })->findOrFail($conversationId);

        $messages = Message::where('conversation_id', $conversation->id)
                            ->with('sender', 'receiver')
                            ->orderBy('created_at', 'asc')
                            ->get();

        // Mark messages as read (optional: can be done more efficiently)
        // This is a simple implementation. For production, consider a more robust solution.
        Message::where('conversation_id', $conversation->id)
                ->where('receiver_id', $user->idUser)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|string|exists:users,idUser',
            'body' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id' // Optional: if starting a new chat or continuing existing
        ]);

        $sender = Auth::user();
        $receiverId = $request->receiver_id;
        $body = $request->body;

        // Prevent sending message to self
        if ($sender->idUser === $receiverId) {
            return response()->json(['error' => 'Cannot send message to yourself.'], 400);
        }

        $conversationId = $request->conversation_id;
        $conversation = null;

        if ($conversationId) {
            $conversation = Conversation::findOrFail($conversationId);
            // Ensure the authenticated user is part of this conversation
            if ($conversation->guru_id !== $sender->idUser && $conversation->mentor_id !== $sender->idUser) {
                return response()->json(['error' => 'Unauthorized to send message to this conversation.'], 403);
            }
        } else {
            // Find or create a conversation between the sender and receiver
            // Determine who is guru and who is mentor based on their roles or a predefined logic
            // For this example, we assume the sender can be either guru or mentor
            // and the receiver is the other party.
            // You might need a more sophisticated way to determine guru_id and mentor_id
            // based on your application logic (e.g., if a user has ProfilGuru or ProfilMentor)

            // A simple approach: check if a conversation already exists
            $conversation = Conversation::where(function ($query) use ($sender, $receiverId) {
                $query->where('guru_id', $sender->idUser)->where('mentor_id', $receiverId);
            })->orWhere(function ($query) use ($sender, $receiverId) {
                $query->where('guru_id', $receiverId)->where('mentor_id', $sender->idUser);
            })->first();

            if (!$conversation) {
                // Determine who is guru and who is mentor. This is a placeholder.
                // You need to implement logic to correctly assign guru_id and mentor_id.
                // For instance, check if $sender has a ProfilMentor, then they are the mentor.
                // Or if the $request includes who the sender is initiating the chat with (a mentor or a guru).
                // For now, let's assume if sender has profilMentor, they are mentor, else guru.
                // This is a simplified assumption.
                $senderIsMentor = $sender->profilMentor()->exists(); // Assuming you have this relationship

                $conversation = Conversation::create([
                    'guru_id' => $senderIsMentor ? $receiverId : $sender->idUser,
                    'mentor_id' => $senderIsMentor ? $sender->idUser : $receiverId,
                    'last_message_at' => now(),
                ]);
            }
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $sender->idUser,
            'receiver_id' => $receiverId,
            'body' => $body,
        ]);

        $conversation->update(['last_message_at' => $message->created_at]);

        // Broadcast the message
        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json($message->load('sender', 'receiver'));
    }

    public function editMessage(Request $request, $messageId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $user = Auth::user();
        $message = Message::findOrFail($messageId);

        // Ensure the authenticated user is the sender of the message
        if ($message->sender_id !== $user->idUser) {
            return response()->json(['error' => 'Unauthorized to edit this message.'], 403);
        }

        $message->body = $request->body;
        $message->save();

        return response()->json($message->load('sender', 'receiver'));
    }

    public function deleteMessage($messageId)
    {
        $user = Auth::user();
        $message = Message::findOrFail($messageId);

        // Ensure the authenticated user is the sender of the message
        if ($message->sender_id !== $user->idUser) {
            return response()->json(['error' => 'Unauthorized to delete this message.'], 403);
        }

        $message->delete();

        return response()->json(null, 204);
    }
}
