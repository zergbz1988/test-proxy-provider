<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\Domain\Port;

class PortTest extends TestCase
{
    public function testNegativePortWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Port::of(-1);
    }
}
