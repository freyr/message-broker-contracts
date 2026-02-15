# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Shared contracts library for the Freyr Message Broker — provides interfaces, stamps, and attributes used across services that communicate via Symfony Messenger. This is a **library package** (not an application), so there is no runtime entry point.

## Commands

All commands run through Docker Compose (`php` service, PHP 8.4):

```bash
# Install dependencies
docker compose run --rm php composer install

# Run tests
docker compose run --rm php composer test

# Run a single test class
docker compose run --rm php vendor/bin/phpunit tests/MessageNameTest.php

# Run a single test method
docker compose run --rm php vendor/bin/phpunit --filter itAcceptsValidTwoSegmentName

# Static analysis (PHPStan level max)
docker compose run --rm php composer phpstan

# Coding standards check
docker compose run --rm php composer ecs

# Coding standards auto-fix
docker compose run --rm php composer ecs:fix
```

## Architecture

Namespace: `Freyr\MessageBroker\Contracts` (PSR-4 mapped to `src/`).

**Core contracts:**
- `OutboxMessage` — marker interface; messages implementing this are routed through the outbox pattern
- `OutboxPublisherInterface` — publishes an `Envelope` to an external transport (AMQP, SQS, etc.)
- `DeduplicationStore` — inbox-side deduplication; `isDuplicate()` atomically checks and marks message IDs

**Stamps** (Symfony Messenger `StampInterface` implementations):
- `MessageIdStamp` — carries a `Freyr\Identity\Id` (UUID v7) for deduplication and tracing
- `MessageNameStamp` — carries the semantic message name string

**Attribute + trait:**
- `#[MessageName('domain.action')]` — PHP attribute on message classes; enforces lowercase dot-separated naming with minimum two segments (regex: `/\A[a-z][a-z0-9]*(\.[a-z][a-z0-9]*)+\z/`)
- `ResolvesFromClass` trait — cached reflection-based attribute resolution; each using class maintains its own `$cache` array

## Coding Conventions

- PHP 8.2+ with `declare(strict_types=1)` in every file
- ECS config: PSR-12 + Symfony + Symplify sets; Yoda style disabled; single-line empty bodies enabled
- Tests use PHPUnit attributes (`#[Test]`, `#[DataProvider]`) — not docblock annotations
- Test method names use `itDoesAction` convention (e.g. `itAcceptsValidTwoSegmentName`)
- `final` and `readonly` classes where appropriate
- Depends on `freyr/identity` for `Id` value object (UUID v7)
