<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\Domain\IPAddress;

class IPAddressTest extends TestCase
{
    public function testInvalidAddressWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        IPAddress::of('wrong string');
    }
}
