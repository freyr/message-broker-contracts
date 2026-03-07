<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests;

use Freyr\MessageBroker\Contracts\PartitionKeyStamp;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class PartitionKeyStampTest extends TestCase
{
    #[Test]
    public function itImplementsStampInterface(): void
    {
        $stamp = new PartitionKeyStamp('order-123');
        self::assertInstanceOf(StampInterface::class, $stamp);
    }

    #[Test]
    public function itExposesPartitionKey(): void
    {
        $stamp = new PartitionKeyStamp('order-123');
        self::assertSame('order-123', $stamp->partitionKey);
    }
}
