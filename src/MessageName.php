<?php

declare(strict_types=1);

namespace Freyr\MessageBroker\Contracts;

use Attribute;
use InvalidArgumentException;
use ReflectionClass;

/**
 * MessageName Attribute.
 *
 * Marks domain events/commands with semantic names for messaging.
 * Format: {domain}.{subdomain}.{action} (lowercase alphanumeric, dot-separated, minimum two segments)
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class MessageName
{
    public function __construct(
        public readonly string $name,
    ) {
        if ($name === '' || !preg_match('/\A[a-z][a-z0-9]*(\.[a-z][a-z0-9]*)+\z/', $name)) {
            throw new InvalidArgumentException(sprintf(
                'MessageName must match pattern "segment.segment.segment" (lowercase alphanumeric, dot-separated, minimum two segments). Got: "%s"',
                $name,
            ));
        }
    }

    /**
     * Extract the semantic message name from an object's #[MessageName] attribute.
     *
     * Returns null if the attribute is not present (caller decides the policy).
     */
    public static function fromClass(object $message): ?string
    {
        $attributes = (new ReflectionClass($message))->getAttributes(self::class);

        if ($attributes === []) {
            return null;
        }

        return $attributes[0]->newInstance()->name;
    }
}
