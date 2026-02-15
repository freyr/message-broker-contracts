# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 0.2.0 - 2026-02-15

### Changed
- `MessageName::fromClass()` now uses inline reflection instead of the `ResolvesFromClass` trait

### Removed
- `ResolvesFromClass` trait — reflection caching was no longer necessary; logic inlined into `MessageName`

## 0.1.1 - 2026-02-15

### Added
- QA tooling: PHPStan (level max), ECS (PSR-12 + Symfony), PHPUnit
- CI pipeline with PHP 8.2–8.4 and Symfony 6.4/7.x matrix

## 0.1.0 - 2026-02-13

### Added
- Initial contracts package: `OutboxMessage`, `OutboxPublisherInterface`, `DeduplicationStore`
- `MessageName` attribute with dot-separated naming validation
- `MessageIdStamp` and `MessageNameStamp` Symfony Messenger stamps
- `ResolvesFromClass` trait for cached attribute resolution
