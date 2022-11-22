<?php

declare(strict_types=1);

namespace Proxy\App\Data;

enum FormatEnum: string
{
    case IP = "ip";
    case IPPort = "ip:port";
    case IPLoginPassword = "ip@login:password";
    case Full = "ip:port@login:password";
}
