<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TurboSMS
{
    private static $baseUrl = "https://api.turbosms.ua/message/send.json";
    private static $baseUrlPing = "https://api.turbosms.ua/message/ping.json";
    private static $token = "";

    public static function sendMessage($phone, $text)
    {
        $form = [
            'sender' => 'test',
            'sms' => [
                'text' => $text,
                'recipients' => [
                    $phone
                ],
            ]
        ];

        return Http::withToken(self::$token)->asForm()->post(self::$baseUrl, $form)->body();
    }

    public static function sendPingRequest()
    {
        return Http::withToken(self::$token)->asForm()->post(self::$baseUrlPing, $form)->body();
    }
}
