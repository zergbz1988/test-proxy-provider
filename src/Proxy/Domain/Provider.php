<?php

declare(strict_types=1);

namespace Proxy\Domain;

interface Provider
{
    public function all(): ProxyCollection;
}