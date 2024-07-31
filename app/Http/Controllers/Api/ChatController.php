<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        if ($request->user_1_id === $request->user_2_id) {
            return response()->json([
                "message" => "Invalid request"
            ], 400);
        }

        $validated = $request->validate([
            "user_1_id" => "required|exists:users,id|numeric",
            "user_2_id"=> "required|exists:users,id|numeric"
        ]);


        $existingChat1 = Chat::where('user_1_id', $validated['user_1_id'])->where('user_2_id', $validated['user_2_id'])->first();
        $existingChat2 = Chat::where('user_1_id', $validated['user_1_id'])->where('user_2_id', $validated['user_2_id'])->first();
        if ($existingChat1 ) {
            return response()->json([
                "message" => $existingChat1,
            ], 302);
        }

        if ($existingChat2 ) {
            return response()->json([
                "message" => $existingChat2,
            ], 302);
        }

        $chat = Chat::create($validated);
        return response()->json([
            "message" => "Chat created successfully",
            'chat' => $chat
        ], 201);
    }
    public function deleteChat($id)
    {
        $chat = Chat::find($id);
        $chat->delete();
        return response()->json([], 204);
    }

    public function getUserChats($userId)
    {
        $chats = Chat::where("user_1_id", $userId)->orWhere("user_2_id",$userId)->get();
        if (!$chats) {
            return response()->json([
                'message' => 'Chat not found'
            ], 404);
        }

        return response()->json([
            "chats" => $chats
        ], 200);
    }
}