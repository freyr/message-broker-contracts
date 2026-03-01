# Freyr Message Broker Contracts

Shared contracts library — interfaces, stamps, and attributes used across all message broker packages. Library package with no runtime entry point.

Namespace: `Freyr\MessageBroker\Contracts\`

## Domain Context

**Interfaces:**
- `OutboxMessage` — marker interface; messages implementing this route through the outbox pattern
- `OutboxPublisherInterface` — publishes an `Envelope` to an external transport (AMQP, SQS, etc.)
- `DeduplicationStore` — inbox-side deduplication; `isDuplicate()` atomically checks and marks message IDs

**Stamps** (Symfony Messenger `StampInterface`):
- `MessageIdStamp` — carries `Freyr\Identity\Id` (ULID) for deduplication and tracing
- `MessageNameStamp` — carries semantic message name string

**Attribute:**
- `#[MessageName('domain.action')]` — PHP attribute on message classes
- Enforces lowercase dot-separated naming, minimum two segments
- Regex: `/\A[a-z][a-z0-9]*(\.[a-z][a-z0-9]*)+\z/`
- `MessageName::fromClass()` extracts the attribute via reflection

## Key Files

| File | Purpose |
|------|--------|
| `src/OutboxMessage.php` | Marker interface for outbox routing |
| `src/OutboxPublisherInterface.php` | Transport publisher contract |
| `src/DeduplicationStore.php` | Duplicate detection contract |
| `src/MessageIdStamp.php` | ULID stamp |
| `src/MessageNameStamp.php` | Semantic name stamp |
| `src/MessageName.php` | Attribute + `fromClass()` resolution |

## Patterns & Gotchas

- `DeduplicationStore::isDuplicate()` accepts `Freyr\Identity\Id`, not a string
- `MessageName` validation runs in the constructor — invalid names throw `InvalidArgumentException` at instantiation
- `fromClass()` returns `null` (not exception) when attribute is missing — callers decide policy

## Boundaries

**ASK FIRST:**
- Any interface changes — these are the API boundary for all packages
- New stamps or attributes — ripple to all consumers
