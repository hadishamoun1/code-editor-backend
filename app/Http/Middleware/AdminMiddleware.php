<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

    
        $user  = JWTAuth::parseToken()->authenticate();
       
        //print('AdminMiddleware: User role - ' . ($user->role ?? 'none') . "<br>");
        //print('AdminMiddleware: User details - ' . json_encode($user) . "<br>");

        // Check if the user's role is 'admin'
        if ($user && $user->role == 'admin') {
            return $next($request);
        }
        Log::error('Access denied for non-admin user.');


        return response()->json(['message' => 'Access deneied'], 403);
    }
}
