<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function createMessage(Request $req, $chatId)
    {
        $chatId = Chat::find($chatId);
        
        $validated_data = $req->validate([
            "message" => "required|string",
            "chat_id" => "required|exists:chats,id|numeric"
        ]);
        
        $message = Message::create($validated_data);
        return response()->json([
            "message" => $message
        ], 201);
    }
    public function getAllMessages($chatId)
    {
        $chat = Chat::with(['messages'])->find($chatId);
        return response()->json([
            "chat_id" => $chat->id,
            "messages" => $chat->messages
        ], 200);
    }
    public function updateMessage(Request $req, $id)
    {
        $message= Message::find($id);

        if ($message) {
            $validated_data = $req->validate([
                "message_id" => "required|exists:messages,id|numeric",
            ]);
            $message->update($validated_data);
        }
        return response()->json([
            "message" => $message
        ], 204);
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);
        $message->delete();
        return response()->json([
            "message" => "deleted successfully"
        ], 204);
    }
}
