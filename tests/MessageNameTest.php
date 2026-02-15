<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests;

use Freyr\MessageBroker\Contracts\MessageName;
use Freyr\MessageBroker\Contracts\Tests\Fixtures\UnattributedMessage;
use Freyr\MessageBroker\Contracts\Tests\Fixtures\ValidMessage;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MessageNameTest extends TestCase
{
    #[Test]
    public function itAcceptsValidTwoSegmentName(): void
    {
        $attr = new MessageName('order.placed');
        self::assertSame('order.placed', $attr->name);
    }

    #[Test]
    public function itAcceptsValidThreeSegmentName(): void
    {
        $attr = new MessageName('sla.calculation.started');
        self::assertSame('sla.calculation.started', $attr->name);
    }

    #[Test]
    public function itAcceptsAlphanumericSegments(): void
    {
        $attr = new MessageName('order2.placed3');
        self::assertSame('order2.placed3', $attr->name);
    }

    #[Test]
    #[DataProvider('invalidNameProvider')]
    public function itRejectsInvalidNames(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);
        new MessageName($name);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function invalidNameProvider(): iterable
    {
        yield 'empty string' => [''];
        yield 'single segment' => ['order'];
        yield 'uppercase' => ['Order.Placed'];
        yield 'leading dot' => ['.order.placed'];
        yield 'trailing dot' => ['order.placed.'];
        yield 'double dot' => ['order..placed'];
        yield 'spaces' => ['order. placed'];
        yield 'underscores' => ['order_placed.event'];
        yield 'hyphens' => ['order-placed.event'];
        yield 'starts with number' => ['1order.placed'];
        yield 'segment starts with number' => ['order.1placed'];
    }

    #[Test]
    public function fromClassReturnsNameForAttributedMessage(): void
    {
        $message = new ValidMessage();
        self::assertSame('order.placed', MessageName::fromClass($message));
    }

    #[Test]
    public function fromClassReturnsNullForUnattributedMessage(): void
    {
        $message = new UnattributedMessage();
        self::assertNull(MessageName::fromClass($message));
    }

    #[Test]
    public function fromClassCachesResult(): void
    {
        $message = new ValidMessage();

        // Call twice — second call should use cache
        $first = MessageName::fromClass($message);
        $second = MessageName::fromClass($message);

        self::assertSame($first, $second);
        self::assertSame('order.placed', $first);
    }
}
