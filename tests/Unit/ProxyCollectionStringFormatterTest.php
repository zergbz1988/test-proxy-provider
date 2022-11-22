<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Proxy\App\Service\ProxyCollectionStringFormatter;
use Proxy\App\Service\ProxyStringFormatter;
use Proxy\Domain\IPAddress;
use Proxy\Domain\Password;
use Proxy\Domain\Port;
use Proxy\Domain\Proxy;
use Proxy\Domain\ProxyCollection;

class ProxyCollectionStringFormatterTest extends TestCase
{
    public function testItWorks(): void
    {
        $proxyCollection = ProxyCollection::make([
            new Proxy(
                IPAddress::of('127.0.0.1'),
                Port::of(1234),
                'login1',
                Password::of('test123')
            ),
            new Proxy(
                IPAddress::of('192.168.0.1'),
                Port::of(2354),
                'login2',
                Password::of('h56h3fdfa')
            ),
            new Proxy(
                IPAddress::of('192.168.10.20'),
                Port::of(111),
                'login45',
                Password::of('dfdrte3')
            ),
        ]);

        $proxyStrings = [
            '127.0.0.1',
            '192.168.0.1',
            '192.168.10.20',
        ];

        $formatter = $this->createMock(ProxyStringFormatter::class);
        $formatter->expects($this->exactly(3))->method('format')->willReturn(
            $proxyStrings[0],
            $proxyStrings[1],
            $proxyStrings[2]
        );

        $collectionFormatter = new ProxyCollectionStringFormatter($formatter);
        $strings = $collectionFormatter->format($proxyCollection);

        $this->assertEquals($proxyStrings, $strings);
    }
}
