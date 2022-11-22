<?php

declare(strict_types=1);

namespace Proxy\Domain;

/**
 *  ip, port, login, password
 */
class Proxy
{
    public function __construct(
        public readonly IPAddress $ip,
        public readonly Port $port,
        public readonly string $login,
        public readonly Password $password,
    ) {
    }

    public function toArray(): array
    {
        return [
            'ip' => $this->ip->value,
            'port' => $this->port->value,
            'login' => $this->login,
            'password' => $this->password->value,
        ];
    }
}