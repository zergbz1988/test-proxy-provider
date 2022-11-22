<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Proxy\App\Data\FormatEnum;
use Proxy\App\Service\ProxyStringFormatter;
use Proxy\App\Service\ProxyStringFormatter\Factory;

class ProxyStringFormatterFactoryTest extends TestCase
{
    /** @dataProvider factoryWorksDataProvider */
    public function testItWorks(FormatEnum $format, ProxyStringFormatter $formatter): void
    {
        $actualFormatter = (new Factory())->make($format);

        $this->assertEquals($formatter, $actualFormatter);
    }

    public function factoryWorksDataProvider(): array
    {
        return [
            [FormatEnum::IP, new ProxyStringFormatter\Ip()],
            [FormatEnum::IPPort, new ProxyStringFormatter\IpPort()],
            [FormatEnum::IPLoginPassword, new ProxyStringFormatter\IpLoginPassword()],
            [FormatEnum::Full, new ProxyStringFormatter\Full()],
        ];
    }
}
