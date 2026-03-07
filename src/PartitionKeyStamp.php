<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts;

use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 * Partition key stamp for ordered delivery.
 *
 * Identifies the causal group (e.g. aggregate ID) for per-partition FIFO ordering.
 * Used by transports to enforce message ordering within a partition:
 *   - Ordered outbox: per-partition head-of-line query
 *   - AMQP: routing key grouping
 *   - SQS FIFO: MessageGroupId
 */
final readonly class PartitionKeyStamp implements StampInterface
{
    public function __construct(
        public string $partitionKey,
    ) {}
}
