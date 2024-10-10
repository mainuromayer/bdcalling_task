<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\OtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user(); // Now user is authenticated

                Log::info("User authenticated: {$user->email}");

                // Generate OTP
                $otp = rand(100000, 999999);
                Session::put('otp_email', $user->email);
                Session::put('otp', $otp);
                Session::put('otp_verified', false); // Ensure OTP is not verified yet

                Mail::to($user->email)->send(new OtpMail($otp));
                return redirect()->route('two-steps.login')->with('status', 'OTP sent to your email. Please verify your OTP.');
            }

            Log::warning("Invalid credentials for email: {$request->email}");
            return back()->withErrors(['email' => 'Invalid credentials.']);
        } catch (Exception $e) {
            Log::error("Error in AuthController@loginCheck: {$e->getMessage()}");
            return back()->withErrors(['email' => 'An error occurred.']);
        }
    }


    public function register(): View
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->role = $request->get('role');

            if ($user->save()) {
                return redirect()->route('login')->with('status', 'Registration Successfully.');
            }

            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to register user.']);
        } catch (Exception $exception) {
            Log::error("Error in AuthController@store: {$exception->getMessage()}");
            return Redirect::back()->withInput()->with('error', 'Something went wrong during registration.');
        }
    }

    public function twoStepsLogin(Request $request): View
    {
        $email = $request->session()->get('otp_email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'No email found. Please log in again.');
        }
        return view('auth.two-steps-login', ['email' => $email]);
    }


    public function verifyLoginOtpAction(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|numeric']);

        if ($this->isValidOtp($request->otp)) {
            Session::put('otp_verified', true); // Set OTP as verified
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function verifyResetOtpAction(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|numeric']);

        if ($this->isValidOtp($request->otp)) {
            Session::put('otp_verified', true); // Set OTP as verified
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }



    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordAction(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(100000, 999999);
            session(['otp' => $otp, 'otp_email' => $request->email]);
            Mail::to($request->email)->send(new OtpMail($otp));
            return redirect()->route('two-steps.reset-password')->with('status', 'OTP sent to your email.');
        }

        return back()->withErrors(['email' => 'Email not found.']);
    }

    public function resetPassword(Request $request, string $token): View
    {
        if (!session('password_reset_requested')) {
            return redirect()->route('forgot-password');
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPasswordAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        $status = Password::reset($request->only('email', 'password', 'token'), function ($user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password reset successful.');
        }

        return back()->withErrors(['email' => 'Failed to reset password.']);
    }



    private function isValidOtp($otp)
    {
        return $otp == session('otp');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

}
