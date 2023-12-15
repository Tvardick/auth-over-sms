<?php

namespace App\Actions\AuthCodeAction;

class RandomCode
{
    public static function setCode(): int
    {
        return rand(1111, 9999);
    }
}
