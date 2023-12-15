<?php

namespace App\Actions\SessionAction;

class GiveToSession
{
    public static function put(string $name, string $phone): void
    {
        session()->put('name', $name);
        session()->put('phone', $phone);
    }
}
