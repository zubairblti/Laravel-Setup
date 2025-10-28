<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserLogin extends Controller
{
    public function login(){
        $page_title = "Login User";
        return view('login.login', compact('page_title'));
    }

    public function register(){
        $page_title = "Register User";
        return view('login.register', compact('page_title'));
    }

    public function registerSubmit(Request $request){
        $register = $request->validate([
            'your_name' => 'required',
            'your_email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $otp = rand(100000, 999999);

        $user = new User();
        $user->name = $register['your_name'];
        $user->email = $register['your_email'];
        $user->password = Hash::make($register['password']);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(2);
        $user->save();

        Mail::raw("Your OTP for email verification is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Email Verification OTP');
        });

        return redirect()->route('email.verification', ['email' => $user->email])->with('success', 'OTP Send Your Email');
    }

    public function emailVerification(){
        $page_title = "Email Verification";
        return view('login.email-verification', compact('page_title'));
    }

    public function verifyOtp(Request $request)
    {

        $otp = implode('', $request->otp);
        $request->merge(['otp' => $otp]);
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Invalid OTP.');
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please register again.');
        }

        $user->email_verified_at = now();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }
}