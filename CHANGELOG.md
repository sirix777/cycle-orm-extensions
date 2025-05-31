# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

### Fixed
- Updated EntityInterface to allow null return type from `getIdentifier()` method
