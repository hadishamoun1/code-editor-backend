<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return response()->json(["users" => User::all()],200);
    }

    // Display the specified resource.
    public function show($id)
    {
        return response()->json(["user" =>User::findOrFail($id)],200);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        return User::create($validated);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
             'email' => 'sometimes|string|email|max:255' ,
             'password' => 'sometimes|string|min:8',
        ]);

        $user->update($validated);

        return $user;
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $post = User::findOrFail($id);
        $post->delete();

        return response()->noContent();
    }
}
