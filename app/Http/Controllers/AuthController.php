<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Firebase\JWT\JWT;

use DateTime;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            
            $token = JWT::encode([
                'iss' => env('APP_URL'),
                'aud' => env('APP_URL'),
                'sub' => $user->id,
                'iat' => (new DateTime())->getTimestamp(),
                'user_id' => $user->id,
                'exp' => (new DateTime())->modify('+1 day')->getTimestamp(),
            ], env('JWT_SECRET'), 'HS256');

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
