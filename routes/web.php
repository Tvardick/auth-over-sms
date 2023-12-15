<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserRegistationController,
    UserLoginController,
    UserLogoutController,
    UserVerifyController,
};

Route::middleware('guest')->group(function () {
    Route::post("/reg-create", [UserRegistationController::class, "create"])
        ->name("reg.create");
    Route::post('/verify-code', [UserVerifyController::class, 'verifycationCode'])->name('verify-code');
    Route::post('/login-check', [UserLoginController::class, 'login'])
        ->name('login.check');
    Route::view("/login", 'auth.login')->name('login');
    Route::view("/reg", 'auth.reg')->name('reg');
    Route::view("/verify", 'auth.verify')->name('verify');
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('auth')->group(function () {
    Route::view('/me', "auth.home")->name('me');
    Route::get('logout', [UserLogoutController::class, 'logout'])
        ->name('logout');
    Route::get('/', function () {
        return redirect()->route('me');
    });
});
