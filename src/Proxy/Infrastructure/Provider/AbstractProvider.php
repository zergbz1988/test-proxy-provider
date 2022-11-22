<?php

declare(strict_types=1);

namespace Proxy\Infrastructure\Provider;

use Faker\Generator;
use Proxy\Domain\IPAddress;
use Proxy\Domain\Password;
use Proxy\Domain\Port;
use Proxy\Domain\Provider;
use Proxy\Domain\Proxy;
use Proxy\Domain\ProxyCollection;

class AbstractProvider implements Provider
{
    public function __construct(private readonly Generator $generator)
    {
    }

    public function all(): ProxyCollection
    {
        $result = ProxyCollection::empty();
        $count = $this->generator->numberBetween(1, 10);
        for ($i = 0; $i < $count; $i++) {
            $result->add($this->generateProxy());
        }

        return $result;
    }

    private function generateProxy(): Proxy
    {
        $ip = $this->generator->boolean() ? $this->generator->ipv4() : $this->generator->ipv6();

        return new Proxy(
            ip: IPAddress::of($ip),
            port: Port::of($this->generator->numberBetween(1, 10000)),
            login: $this->generator->userName(),
            password: Password::of($this->generator->bothify('##?#?##???##???###')),
        );
    }
}