<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            $payload = JWTAuth::setToken($token)->getPayload();
            $role = $payload->get('role');

            Log::info('Role from Token:', ['role' => $role]);

            
            if ($role === 'admin' || $role === 'user') {
                return $next($request);
            }

            return response()->json(['error' => 'Unauthorized'], 403);
        } catch (\Exception $e) {
            Log::error('Token Error:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
