<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Proxy\Domain\IPAddress;
use Proxy\Domain\Password;
use Proxy\Domain\Port;
use Proxy\Domain\Proxy;

class ProxyTest extends TestCase
{
    public function testConversionToArrayIsAsExpected(): void
    {
        $proxy = new Proxy(
            IPAddress::of('127.0.0.1'),
            Port::of(1234),
            'login1',
            Password::of('test123')
        );

        $arrayResult = [
            'ip' => '127.0.0.1',
            'port' => 1234,
            'login' => 'login1',
            'password' => 'test123'
        ];

        $this->assertEquals($arrayResult, $proxy->toArray());
    }
}
