<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users', 
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);


        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user(); 

        return $this->respondWithToken($token, $user);
    
    }
    /**
     * 
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id, 
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role,
            ]
        ]);
    }
    /**
     * Get the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     public function logout(Request $request)
     {
         try {
             // Invalidate the token
             JWTAuth::invalidate(JWTAuth::getToken());
     
             return response()->json([
                 'status' => 'success',
                 'message' => 'Successfully logged out',
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => 'Failed to log out',
                 'error' => $e->getMessage()
             ], 500);
         }
     }
     
 
     
}
