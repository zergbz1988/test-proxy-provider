<?php

declare(strict_types=1);

namespace Proxy\App\Service;

use Proxy\Domain\Provider;
use Proxy\Domain\ProxyCollection;

class ProxyCollectionReader
{
    public function __construct(private readonly Provider $provider)
    {
    }

    public function read(): ProxyCollection
    {
        return $this->provider->all();
    }
}