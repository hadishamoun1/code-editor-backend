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
        $validated = $request->validate([
            "user_1_id" => '"required|exists:users,id|numeric",',
            "user_2_id"=> '"required|exists:users,id|numeric"',
        ]);

        $userIds = [$validated['user_1_id'], $validated['user_2_id']];
        sort($userIds);

        $existingChat = Chat::where('user_1_id', $userIds[0])->where('user_2_id', $userIds[1])->first();
        if ($existingChat) {
            return response()->json([
                "message" => "Chat already exists between these users",
                "chat" => $existingChat
            ], 200);
        }

        $chat = Chat::create([
            'user_1_id' => $userIds[0],
            'user_2_id' => $userIds[1]
        ]);
        $chat = Chat::create($validated);
        return response()->json([
            "chat"=> $chat
        ], 201);
    }
    public function updateChat(Request $request, $id)
    {
        $chat = Chat::find($id);

        $validated = $request->validate([
            "user_1_id" => "required|exists:users,id|numeric",
            "user-2_id" => "required|exists:users,id|numeric",
        ]);

        $chat->update($validated);

        return response()->json([
            "message" => "Chat updated successfully",
        ], 204);
    }

    public function deleteChat($id)
    {
        $chat = Chat::find($id);
        $chat->delete();
        return response()->json([
            "message" => "deleted successfully"
        ], 204);
    }

    public function getUserChats($userId)
    {
        $user = User::with(['chats'])->find($userId);
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json($user->chats);
    }
}