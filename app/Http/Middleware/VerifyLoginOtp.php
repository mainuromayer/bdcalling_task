<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\JWTToken;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User; // Import the User model

class VerifyLoginOtp
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken() ?? $request->cookie('jwt_token');

        if (!$token) {
            return response()->json(['error' => 'Token not provided.'], 401);
        }

        try {
            $decoded = JWTAuth::setToken($token)->getPayload();
            $userId = $decoded->get('sub');

            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            Auth::login($user);

        } catch (Exception $e) {
            return response()->json(['error' => 'Token is invalid or expired.'], 401);
        }

        return $next($request);
    }
}

