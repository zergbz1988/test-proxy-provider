<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Proxy\App\Service\ProxyCollectionReader;
use Proxy\Domain\IPAddress;
use Proxy\Domain\Password;
use Proxy\Domain\Port;
use Proxy\Domain\Provider;
use Proxy\Domain\Proxy;
use Proxy\Domain\ProxyCollection;

class ProxyCollectionReaderTest extends TestCase
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

        $provider = $this->createMock(Provider::class);
        $provider->expects($this->once())->method('all')->willReturn($proxyCollection);

        $reader = new ProxyCollectionReader($provider);
        $collection = $reader->read();

        $this->assertEquals($proxyCollection, $collection);
    }
}
