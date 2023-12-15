<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Actions\RedisAction\PullPushRedis;
use App\Actions\AuthCodeAction\RandomCode;
use App\Actions\SessionAction\GiveToSession;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserRegistationRequest;
use App\Services\TurboSMS;

class UserRegistationController extends Controller
{
    public function create(UserRegistationRequest $request): RedirectResponse
    {
        ["name" => $name, "phone" => $phone] = $request->validated();

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $code = RandomCode::setCode();
            GiveToSession::put($name, $phone);
            PullPushRedis::pushCode($phone, $code);
            $responce = TurboSMS::sendPingRequest();
            return redirect('verify')->with('error', $code);
        }
        return redirect('login')->with('error', "User is found please log in");
    }
}
