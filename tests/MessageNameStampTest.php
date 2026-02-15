<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests;

use Freyr\MessageBroker\Contracts\MessageNameStamp;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class MessageNameStampTest extends TestCase
{
    #[Test]
    public function itImplementsStampInterface(): void
    {
        $stamp = new MessageNameStamp('order.placed');
        self::assertInstanceOf(StampInterface::class, $stamp);
    }

    #[Test]
    public function itExposesMessageName(): void
    {
        $stamp = new MessageNameStamp('order.placed');
        self::assertSame('order.placed', $stamp->messageName);
    }
}
