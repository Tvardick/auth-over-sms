<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserLogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('error', "You are logout now!");
    }
}
