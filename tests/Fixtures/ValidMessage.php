<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests\Fixtures;

use Freyr\MessageBroker\Contracts\MessageName;
use Freyr\MessageBroker\Contracts\OutboxMessage;

#[MessageName('order.placed')]
final readonly class ValidMessage implements OutboxMessage {}
