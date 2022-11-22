<?php

declare(strict_types=1);

namespace Proxy\App\Service;

use Proxy\Domain\Proxy;

interface ProxyStringFormatter
{
    public function format(Proxy $proxy): string;
}