<?php

namespace App\Http\Controllers\Auth;

use App\Helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $jwtToken = JWTAuth::fromUser($user);
                $otp = rand(100000, 999999);
                Session::put('otp_email', $user->email);
                Session::put('otp', $otp);
                Session::put('otp_verified', false);

                Mail::to($user->email)->send(new OtpMail($otp));

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP sent to your email. Please verify your OTP.',
                    'token' => $jwtToken,
                ]);
            }

            return response()->json(['error' => 'Invalid credentials'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred during login'], 500);
        }
    }


    public function someProtectedAction(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Registration successful'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to register user'], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(100000, 999999);
            session(['otp' => $otp, 'otp_email' => $request->email]);
            Mail::to($request->email)->send(new OtpMail($otp));

            return response()->json(['status' => 'success', 'message' => 'OTP sent to your email']);
        }

        return response()->json(['error' => 'Email not found'], 404);
    }

    public function resetPasswordAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Password reset successful']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to reset password'], 500);
        }
    }

    public function verifyLoginOtpAction(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        if ($request->otp == session('otp')) {
            session(['otp_verified' => true]);
            return response()->json(['status' => 'success', 'message' => 'OTP verified']);
        }

        return response()->json(['error' => 'Invalid OTP'], 400);
    }

    public function verifyResetOtpAction(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        if ($request->otp == session('otp')) {
            return response()->json(['status' => 'success', 'message' => 'OTP verified']);
        }

        return response()->json(['error' => 'Invalid OTP'], 400);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
    }
}
