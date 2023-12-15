<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\UserRegistationController;

class UserCreate extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new UserRegistationController();
    }
    public function test_create(): void
    {
        $this->assertTrue(true);
    }
}
