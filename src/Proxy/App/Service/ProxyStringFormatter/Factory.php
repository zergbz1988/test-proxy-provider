<?php

declare(strict_types=1);

namespace Proxy\App\Service\ProxyStringFormatter;

use Proxy\App\Data\FormatEnum;
use Proxy\App\Service\ProxyStringFormatter;

class Factory
{
    public function make(FormatEnum $format): ProxyStringFormatter
    {
        $class = match ($format) {
            FormatEnum::IP => ProxyStringFormatter\Ip::class,
            FormatEnum::IPPort => ProxyStringFormatter\IpPort::class,
            FormatEnum::IPLoginPassword => ProxyStringFormatter\IpLoginPassword::class,
            FormatEnum::Full => ProxyStringFormatter\Full::class,
        };

        return new $class();
    }
}