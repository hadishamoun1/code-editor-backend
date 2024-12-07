<?php

namespace App\Http\Controllers\Api;
use App\Models\Code;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         
        $userId = $request->query('user_id');

        if ($userId) {
            
            $codes = Code::where('user_id', $userId)->get();
            return response()->json($codes);
        }

        return Code::all();
    }
         
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'required|string',
        ]);

       

        return Code::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Code::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $code = Code::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'language' => 'sometimes|string',
        ]);

        $code->update($validated);

        return $code;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Code::findOrFail($id);
        $post->delete();

        return response()->noContent();
    }
}
