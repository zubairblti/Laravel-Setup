<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserLogin;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
Route::get('login', [UserLogin::class, 'login'])->name('login');
Route::get('register', [UserLogin::class, 'register'])->name('register');
Route::post('register/submit', [UserLogin::class, 'registerSubmit'])->name('register.submit');
Route::get('email-verification/{email}', [UserLogin::class, 'emailVerification'])->name('email.verification');
Route::post('/verify-otp', [UserLogin::class, 'verifyOtp'])->name('verify.otp.submit');