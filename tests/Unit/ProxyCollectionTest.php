<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\Domain\ProxyCollection;

class ProxyCollectionTest extends TestCase
{
    public function testAddNotProxyWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection = ProxyCollection::empty();
        $collection->add('wrong value');
    }
}
