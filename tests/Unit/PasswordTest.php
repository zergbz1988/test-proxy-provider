<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\Domain\Password;

class PasswordTest extends TestCase
{
    public function testTooShortPasswordWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Password::of('short');
    }
}
