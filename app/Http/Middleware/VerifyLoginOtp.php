<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\JWTToken;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User; // Import the User model

class VerifyLoginOtp
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('jwt_token');

        if ($token) {
            $decoded = JWTToken::VerifyToken($token);
            if (!$decoded) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized']);
            }

            $user = User::find($decoded->id);
            if ($user) {
                Auth::login($user);
            } else {
                return redirect()->route('login')->withErrors(['error' => 'User not found.']);
            }
        } else {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (!session('otp_verified')) {
                if (!$request->routeIs('two-steps.login') && !$request->routeIs('verify-login.otp.action')) {
                    return redirect()->route('two-steps.login')->withErrors(['otp' => 'You must verify your OTP first to log in.']);
                }
            }
        }

        return $next($request);
    }
}

