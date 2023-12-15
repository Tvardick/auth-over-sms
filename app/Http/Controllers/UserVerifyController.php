<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Actions\RedisAction\PullPushRedis;
use App\Models\User;

class UserVerifyController extends Controller
{
    public function verifycationCode(Request $request)
    {
        $name = session('name');
        $phone = session('phone');
        $code = $request->input('code');

        if (PullPushRedis::verifyCode($phone, $code)) {
            $user = User::create(
                [
                    "name" => $name,
                    "phone" => $phone
                ]
            );
            Auth::login($user);

            return redirect()->route('me')->with("error", 'You Are Log in');
        }

        return back()->with('error', "This code isn't right, check it");
    }

}
