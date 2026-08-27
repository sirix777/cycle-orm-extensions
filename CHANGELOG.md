# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [4.1.0] - 2026-08-27

### Changed
- Money and currency typecasts now use `brick/money` directly.
- `MoneyCurrencyCodeType` and `MoneyMinorCurrencyCodeType` now accept an ISO 4217 currency-code string instead of a `sirix/money` enum.

### Added
- Added catalog-based `Typecast\SirixMoney` types backed by `sirix/money` 2.x `MoneyFactory` and `CurrencyCatalog`.
- Added `EnumNativeTypecast` callbacks for string- and int-backed enums.

### Removed
- Removed the `sirix/money` 1.x enum-based currency casts and crypto-currency support.
- Removed `CurrencyCodeType` and `CurrencyCodeNativeTypecast`; use `Typecast\SirixMoney\CurrencyType` with a v2 catalog or `Typecast\Currency\CurrencyType` for ISO 4217 currencies.


## [4.0.0] - 2026-08-12

### Removed
- Removed `Sirix\Cycle\Extension\Factory\SelectFactory` class. Repositories no longer require `SelectFactory` - Cycle ORM injects the entity-scoped `Select` instance directly.
- Removed `abstract protected function getEntityClass(): string` from `AbstractReadRepository`. Entity role is now determined by the Cycle schema (`repository:` option on the entity).

### Changed
- `AbstractReadRepository` constructor now accepts `Cycle\ORM\Select $select` directly. The explicit constructor was removed as it delegates to the parent `Repository` class.
- `AbstractWriteRepository` constructor signature changed to `__construct(Select $select, ORMInterface $orm)`.
- Repository example classes updated to reflect the new constructor signatures.

### Breaking Changes
- `SelectFactory` no longer exists. Remove all references from your DI container and repository constructors.
- Repository subclasses must no longer implement `getEntityClass()`. Remove the method and map the repository to the entity via `#[Entity(repository: ...)]` or schema definition.
- `AbstractWriteRepository` constructor parameter order: `Select $select` first, `ORMInterface $orm` second.


## [3.0.1] - 2026-03-10

### Added
- Added enum typecast attributes for backed enums:
  - `Sirix\Cycle\Extension\Typecast\Enum\IntegerEnumType`
  - `Sirix\Cycle\Extension\Typecast\Enum\StringEnumType`


## [3.0.0] - 2026-03-09

### Added
- Added Cycle-style Chronos schema modifiers for schema-builder usage:
  - `Sirix\Cycle\Extension\Behavior\ChronosCreatedAt`
  - `Sirix\Cycle\Extension\Behavior\ChronosUpdatedAt`
  - `Sirix\Cycle\Extension\Behavior\ChronosSoftDelete`
- Added native Cycle-compatible Chronos field typecast callbacks:
  - `Sirix\Cycle\Extension\Typecast\Chronos\ChronosNativeTypecast::toChronos`
  - `Sirix\Cycle\Extension\Typecast\Chronos\ChronosNativeTypecast::toChronosFromTimestamp`
- Added native Cycle-compatible UUID field typecast callbacks:
  - `Sirix\Cycle\Extension\Typecast\Uuid\UuidNativeTypecast::toUuid`
  - `Sirix\Cycle\Extension\Typecast\Uuid\UuidNativeTypecast::toUuidFromString`
  - `Sirix\Cycle\Extension\Typecast\Uuid\UuidNativeTypecast::toUuidFromBytes`
- Added native Cycle-compatible callbacks for remaining value groups:
  - `Sirix\Cycle\Extension\Typecast\Array\ArrayNativeTypecast::*`
  - `Sirix\Cycle\Extension\Typecast\Boolean\BooleanNativeTypecast::toBool`
  - `Sirix\Cycle\Extension\Typecast\Currency\CurrencyNativeTypecast::toCurrency`
  - `Sirix\Cycle\Extension\Typecast\CurrencyCode\CurrencyCodeNativeTypecast::toCurrencyCode`
  - `Sirix\Cycle\Extension\Typecast\Money\MoneyNativeTypecast::*`
- Added unit tests for new Chronos schema modifiers.

### Breaking Changes
- Replaced external `vjik/cycle-typecast` integration with an internal typecast layer (`TypeInterface`, contexts, handlers).
- Public typecast contracts now use `Sirix\Cycle\Extension\Typecast\*` namespaces instead of `Vjik\CycleTypecast\*`.
- Removed `vjik/cycle-typecast` from `composer.json` (`require-dev` and `suggest`).

### Changed
- Updated typecast classes, examples, tests, and README to use `Sirix\Cycle\Extension\Typecast\*` contracts and handlers.

### Upgrade Guide
1. Replace `Vjik\CycleTypecast\AttributeTypecastHandler` with `Sirix\Cycle\Extension\Typecast\Handler\AttributeTypecastHandler`.
2. Replace `Vjik\CycleTypecast\TypecastHandler` with `Sirix\Cycle\Extension\Typecast\Handler\TypecastHandler`.
3. Replace `Vjik\CycleTypecast\TypeInterface` with `Sirix\Cycle\Extension\Typecast\Contract\TypeInterface`.
4. Replace `Vjik\CycleTypecast\CastContext` and `Vjik\CycleTypecast\UncastContext` with internal context classes under `Sirix\Cycle\Extension\Typecast\Context\*`.

### Acknowledgements
- Internal typecast architecture is inspired by `vjik/cycle-typecast` by Sergei Predvoditelev.


## [2.2.0] - 2026-01-29

### Added
- Attribute support for all typecast classes via `#[Attribute(Attribute::TARGET_PROPERTY)]`.
- New typecast-oriented traits for identifiers and timestamps: `HasUuidIdentifierTypecastTrait`, `HasChronosCreateTimestampTypecastTrait`, etc.
- Extensive unit tests for all typecast implementations and traits.

### Changed
- Refactored entity traits to use `vjik/cycle-typecast` attributes for typecasting.
- `AbstractMoneyType` and its implementations now support nullable values in `convertToDatabaseValue` and `convertToPhpValue`.
- Updated examples and tests to use `AttributeTypecastHandler` from `vjik/cycle-typecast`.
- Updated README.md with examples of attribute-based typecasting and new traits.


## [2.1.2] - 2025-11-07

### Changed
- Explicitly mark `id` column as primary in `HasIdIdentifierAnnotatedTrait` (added `primary: true` to `#[Column]`)
- Creation timestamp fields are now non-nullable and corresponding getters return non-nullable `Chronos` in: `HasChronosCreateTrait`, `HasChronosCreateDatetimeAnnotatedTrait`, `HasChronosCreateTimestampAnnotatedTrait`
- Update/delete timestamp columns are now annotated as `nullable: true` in: `HasChronosUpdateDatetimeAnnotatedTrait`, `HasChronosUpdateTimestampAnnotatedTrait`, `HasChronosDeleteDatetimeAnnotatedTrait`, `HasChronosDeleteTimestampAnnotatedTrait`

## [2.1.1] - 2025-10-31

### Added
- Unit test `EventListenersTest` covering schema modification behavior

### Changed
- Minor internal updates in `EventListeners` for schema listeners formatting

## [2.1.0] - 2025-10-22

### Changed
- Moved contracts under the `Sirix\Cycle\Extension\Domain\Contract` namespace (e.g. EntityInterface and repository interfaces)

### Added
- Composer Normalize tool configuration under tools/composer-normalize

### Fixed
- Adjusted tests and examples to reflect the new namespaces and repository changes

## [2.0.0] - 2025-06-02

### Breaking Changes
- Changed visibility of properties in entity traits from protected to private
- Added flush() method to WriteRepositoryInterface

### Changed
- Added test command to the check script in composer.json

## [1.0.0] - 2025-05-31

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
