<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class VerifyLoginOtp
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
//        if (!Auth::check()) {
//            return redirect()->route('login');
//        }

        // Check if OTP is verified
        if (!session('otp_verified')) {
            if (!$request->routeIs('two-steps.login') && !$request->routeIs('verify-login.otp.action')) {
                return redirect()->route('two-steps.login')->withErrors(['otp' => 'You must verify your OTP first to log in.']);
            }
        }

        return $next($request);
    }
}
