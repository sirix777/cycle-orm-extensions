# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.1] - 31/10/2025

### Added
- Unit test `EventListenersTest` covering schema modification behavior

### Changed
- Minor internal updates in `EventListeners` for schema listeners formatting

## [2.1.0] - 22/10/2025

### Changed
- Moved contracts under the `Sirix\Cycle\Extension\Domain\Contract` namespace (e.g. EntityInterface and repository interfaces)

### Added
- Composer Normalize tool configuration under tools/composer-normalize

### Fixed
- Adjusted tests and examples to reflect the new namespaces and repository changes

## [2.0.0] - 02/06/2025

### Breaking Changes
- Changed visibility of properties in entity traits from protected to private
- Added flush() method to WriteRepositoryInterface

### Changed
- Added test command to the check script in composer.json

## [1.0.0] - 31/05/2025

### Added
- Initial release of the Cycle ORM Extensions package
- Entity traits for common functionality (timestamps, UUIDs, etc.)
- Annotated entity traits with Cycle ORM annotations
- Base repository implementations (AbstractReadRepository, AbstractWriteRepository)
- Custom typecasts for various data types (Array, Boolean, Chronos datetime, UUID)
- Event listeners for entity lifecycle events
- Example implementations demonstrating usage patterns
- Money typecasts for handling money values with different currency representations
- Currency typecasts for handling currency objects
- CurrencyCode typecasts for handling currency codes
- Added sirix/money as a suggested dependency
