<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function createMessage(Request $req)
    {
        
        $validated_data = $req->validate([
            "chat_id" => "required|exists:chats,id|numeric",
            "user_id" => "required|exists:users,id|numeric",
            "message" => "required|string",
        ]);
        return Message::create($validated_data);
         
    }
    public function getAllMessages($chatId)
    {
        $chat = Chat::find($chatId);
        if (!$chat) {
            return response()->json([
                "message" => "Chat not found"
            ], 404); 
        }
        return response()->json([
            "messages" => $chat->messages
        ], 200);
    }
    public function updateMessage(Request $req, $msgId)
    {
        $msg = Message::find($msgId);
        if ($msg) {
            $msg->message = $req->message;
            $msg->save();
            return response()->json([
                "message" => "Message updated successfully"
            ],204);
        }
        return response()->json([
            "message" => "Message not found"
        ], 404);
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);
        $message->delete();
        return response()->json([],204);
    }
}
