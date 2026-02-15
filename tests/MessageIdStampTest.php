<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests;

use Freyr\Identity\Id;
use Freyr\MessageBroker\Contracts\MessageIdStamp;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class MessageIdStampTest extends TestCase
{
    #[Test]
    public function itImplementsStampInterface(): void
    {
        $stamp = new MessageIdStamp(Id::new());
        self::assertInstanceOf(StampInterface::class, $stamp);
    }

    #[Test]
    public function itExposesMessageId(): void
    {
        $id = Id::new();
        $stamp = new MessageIdStamp($id);

        self::assertSame($id, $stamp->messageId);
    }
}
