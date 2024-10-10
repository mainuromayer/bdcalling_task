<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyResetOtp
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !session('otp_verified')) {
            return redirect()->route('two-steps.reset-password')->withErrors(['otp' => 'Please verify your OTP first.']);
        }

        return $next($request);
    }
}
