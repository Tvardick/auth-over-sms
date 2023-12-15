<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserLoginRequest;
use App\Actions\RedisAction\PullPushRedis;
use App\Actions\AuthCodeAction\RandomCode;
use App\Actions\SessionAction\GiveToSession;

class UserLoginController extends Controller
{
    private const SEC_IN_FIVE_MINUTS = 300;

    public function login(UserLoginRequest $request): RedirectResponse
    {
        ['phone' => $phone] = $request->validated();

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return redirect()->route('reg')->with('error', 'please registrate first');
        }
        
        $dataFromRedis = PullPushRedis::checkLastLoged($phone);

        if ($dataFromRedis) {
            $diffFromLastSentSMS = Carbon::create($dataFromRedis)->diffInSeconds(now());
            $diffForCustomers = self::SEC_IN_FIVE_MINUTS - $diffFromLastSentSMS;
            $message = "You can login again after {$diffForCustomers} seconds";
            return back()->with('error', $message);
        }

        $code = RandomCode::setCode();
        GiveToSession::put($user->name, $phone);
        PullPushRedis::pushCode($phone, $code);
        // send sms here
        return redirect('verify')->with('error', $code);
    }
}
