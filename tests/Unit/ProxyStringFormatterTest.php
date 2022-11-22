<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Proxy\App\Service\ProxyStringFormatter;
use Proxy\Domain\IPAddress;
use Proxy\Domain\Password;
use Proxy\Domain\Port;
use Proxy\Domain\Proxy;

class ProxyStringFormatterTest extends TestCase
{
    /** @dataProvider stringFormatterWorksDataProvider */
    public function testItWorks(ProxyStringFormatter $formatter, string $formattedProxy): void
    {
        $proxy = new Proxy(
            IPAddress::of('127.0.0.1'),
            Port::of(1234),
            'login1',
            Password::of('test123')
        );

        $this->assertEquals($formatter->format($proxy), $formattedProxy);
    }

    public function stringFormatterWorksDataProvider(): array
    {
        return [
            [new ProxyStringFormatter\Ip(), '127.0.0.1'],
            [new ProxyStringFormatter\IpPort(), '127.0.0.1:1234'],
            [new ProxyStringFormatter\IpLoginPassword(), '127.0.0.1@login1:test123'],
            [new ProxyStringFormatter\Full(), '127.0.0.1:1234@login1:test123']
        ];
    }
}
