<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->bearerToken() === null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $request->bearerToken();
        $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        
        if($payload->exp < time()) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        return $next($request);
    }
}
