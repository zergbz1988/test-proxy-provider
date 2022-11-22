<?php

declare(strict_types=1);

namespace Proxy\App\Service\ProxyStringFormatter;

use Proxy\App\Service\ProxyStringFormatter;
use Proxy\Domain\Proxy;

class Full implements ProxyStringFormatter
{

    public function format(Proxy $proxy): string
    {
        return $proxy->ip->value . ':' . $proxy->port->value . '@' . $proxy->login . ':' . $proxy->password->value;
    }
}