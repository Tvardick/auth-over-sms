<?php

namespace App\Actions\RedisAction;

use Illuminate\Support\Facades\Redis;

class PullPushRedis
{
    private const SMS_TEMPLATE = "sms: ";
    private const TIME_TEMPLATE = "time: ";

    public static function pushCode(string $phone, int $code): void
    {
        Redis::set(self::SMS_TEMPLATE . $phone, $code);
        Redis::expire(self::SMS_TEMPLATE . $phone, 300);

        Redis::set(self::TIME_TEMPLATE . $phone, now());
        Redis::expire(self::TIME_TEMPLATE . $phone, 300);
    }

    public static function checkLastLoged(string $phone)
    {
        return Redis::get(self::TIME_TEMPLATE . $phone);
    }

    public static function verifyCode(string $phone, string $code): bool
    {
        $storedCode = Redis::get(self::SMS_TEMPLATE . $phone);
        return $storedCode === $code;
    }
}
