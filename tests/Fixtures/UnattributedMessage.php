<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts\Tests\Fixtures;

use Freyr\MessageBroker\Contracts\OutboxMessage;

final readonly class UnattributedMessage implements OutboxMessage {}
