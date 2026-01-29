# Cycle ORM Extensions

Practical extensions for Cycle ORM: base repositories, entity traits, typecasts, and more.

[![Latest Stable Version](http://poser.pugx.org/sirix/cycle-orm-extensions/v)](https://packagist.org/packages/sirix/cycle-orm-extensions)
[![Total Downloads](http://poser.pugx.org/sirix/cycle-orm-extensions/downloads)](https://packagist.org/packages/sirix/cycle-orm-extensions)
[![Latest Unstable Version](http://poser.pugx.org/sirix/cycle-orm-extensions/v/unstable)](https://packagist.org/packages/sirix/cycle-orm-extensions)
[![License](http://poser.pugx.org/sirix/cycle-orm-extensions/license)](https://packagist.org/packages/sirix/cycle-orm-extensions)
[![PHP Version Require](http://poser.pugx.org/sirix/cycle-orm-extensions/require/php)](https://packagist.org/packages/sirix/cycle-orm-extensions)


## Overview

This package provides a collection of practical extensions for [Cycle ORM](https://cycle-orm.dev/), including:

- Entity traits for common functionality (timestamps, UUIDs, etc.)
- Base repository implementations
- Custom typecasts
- Event listeners
- And more

## Requirements

- PHP 8.1, 8.2, 8.3, or 8.4
- Cycle ORM 2.10+
- Ramsey UUID 4.7+

## Installation

Install the package via composer:

```bash
composer require sirix/cycle-orm-extensions
```

## Features

### Entity Traits

The package provides several traits for common entity functionality:

#### Standard Traits

- `HasChronosCreateTrait` - Adds creation timestamp functionality
- `HasChronosUpdateTrait` - Adds update timestamp functionality
- `HasChronosDeleteTrait` - Adds deletion timestamp functionality
- `HasIdIdentifierTrait` - Adds integer ID primary key functionality
- `HasUuidIdentifierTrait` - Adds UUID primary key functionality

#### Annotated Traits

Annotated versions of the traits that include Cycle ORM annotations:

- `HasChronosCreateTimestampAnnotatedTrait` - Adds creation timestamp with annotations
- `HasChronosCreateDatetimeAnnotatedTrait` - Adds creation datetime with annotations
- `HasChronosUpdateTimestampAnnotatedTrait` - Adds update timestamp with annotations
- `HasChronosUpdateDatetimeAnnotatedTrait` - Adds update datetime with annotations
- `HasChronosDeleteTimestampAnnotatedTrait` - Adds deletion timestamp with annotations
- `HasChronosDeleteDatetimeAnnotatedTrait` - Adds deletion datetime with annotations
- `HasIdIdentifierAnnotatedTrait` - Adds integer ID primary key with annotations
- `HasUuidIdentifierAnnotatedTrait` - Adds UUID primary key with annotations
- `HasUuidIdentifierStringAnnotatedTrait` - Adds UUID primary key (string) with annotations
- `HasUuidIdentifierByteAnnotatedTrait` - Adds UUID primary key (binary) with annotations

### Repositories

Base repository implementations for common operations:

- `AbstractReadRepository` - Base repository for read-only operations
- `AbstractWriteRepository` - Base repository for read-write operations

#### SelectFactory

The `SelectFactory` is a utility class used by repositories to create `Cycle\ORM\Select` instances. It ensures that the role passed to the select is a valid entity class implementing `EntityInterface`.

In your application, you should register `SelectFactory` in your dependency injection container. Registration example:

```php
use Sirix\Cycle\Extension\Factory\SelectFactory;
use Cycle\ORM\ORMInterface;

/** @var ORMInterface $orm */
$selectFactory = new SelectFactory($orm);
```

Repositories provided by this package require `SelectFactory` in their constructor:

```php
use Sirix\Cycle\Extension\Repository\AbstractReadRepository;
use Sirix\Cycle\Extension\Factory\SelectFactory;

class MyRepository extends AbstractReadRepository
{
    public function __construct(SelectFactory $selectFactory)
    {
        parent::__construct($selectFactory);
    }

    protected function getEntityClass(): string
    {
        return MyEntity::class;
    }
}
```

### Typecasts

Custom typecasts for various data types, implemented as [vjik/cycle-typecast](https://github.com/vjik/cycle-typecast) types.

#### Annotation-based Typecasting

The package supports typecasting via PHP 8 attributes. This allows you to define typecasting logic directly on entity properties.

To use this feature, you need to configure `Vjik\CycleTypecast\AttributeTypecastHandler` for your entity and use the provided type attributes:

```php
use Cycle\Annotated\Annotation\Entity;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToStringType;
use Vjik\CycleTypecast\AttributeTypecastHandler;
use Ramsey\Uuid\UuidInterface;

#[Entity(
    typecast: AttributeTypecastHandler::class,
)]
class User
{
    #[UuidToStringType]
    private UuidInterface $uuid;
}
```

Available type attributes:

- **Arrays**:
    - `#[ArrayToDelimitedStringType(delimiter: ',')]` - Converts array to string and vice versa.
    - `#[EnumArrayToDelimitedStringType(enumClass: MyEnum::class, delimiter: ',')]` - Converts array of backed enums to string.
    - `#[ArrayToJsonType]` - Converts array to JSON string.
- **Boolean**:
    - `#[BooleanToIntType]` - Converts boolean to integer (0 or 1).
- **Chronos (CakePHP Chronos)**:
    - `#[ChronosToTimestampType]` - Converts Chronos to UNIX timestamp (string/int).
    - `#[ChronosToDateTimeStringType]` - Converts Chronos to 'Y-m-d H:i:s' string.
    - `#[ChronosToDateStringType]` - Converts Chronos to 'Y-m-d' string.
- **Currency (Brick\Money)**:
    - `#[CurrencyType]` - Converts `Brick\Money\Currency` to numeric code.
    - `#[CurrencyCodeType]` - Converts `Sirix\Money\CurrencyCode` (fiat/crypto) to value.
- **Money (Brick\Money)**:
    - `#[MoneyCurrencyCodeType(currencyCode: FiatCurrencyCode::Eur)]` - Converts `Brick\Money\Money` to string amount using specified currency.
    - `#[MoneyCurrencyNumericCodeColumnType(currencyCodeEntityProperty: 'currencyCode')]` - Converts `Brick\Money\Money` to string amount, using another entity property for currency code.
    - `#[MoneyMinorCurrencyCodeType(currencyCode: FiatCurrencyCode::Eur)]` - Converts `Brick\Money\Money` to integer (minor units).
    - `#[MoneyMinorCurrencyNumericCodeColumnType(currencyCodeEntityProperty: 'currencyCode')]` - Converts `Brick\Money\Money` to integer (minor units), using another entity property for currency code.
- **UUID (Ramsey\Uuid)**:
    - `#[UuidToBytesType]` - Converts UUID to binary.
    - `#[UuidToStringType]` - Converts UUID to string.

#### Typecast Traits

For common scenarios, the package provides traits that combine property definition, Cycle ORM annotations, and typecasting:

- `HasUuidIdentifierTypecastTrait` - UUID primary key (string 36).
- `HasUuidIdentifierStringTypecastTrait` - UUID primary key (explicit string 36).
- `HasUuidIdentifierByteTypecastTrait` - UUID primary key (binary 16).
- `HasChronosCreateTimestampTypecastTrait`, `HasChronosCreateDatetimeTypecastTrait` - Creation timestamps.
- `HasChronosUpdateTimestampTypecastTrait`, `HasChronosUpdateDatetimeTypecastTrait` - Update timestamps.
- `HasChronosDeleteTimestampTypecastTrait`, `HasChronosDeleteDatetimeTypecastTrait` - Soft delete timestamps.

### Event Listeners

The `EventListeners` attribute lets you declare Cycle ORM entity listeners directly on the entity class. It injects the configured listeners into the entity schema under `SchemaInterface::LISTENERS`.

Note: To use listeners, you must install the Cycle Entity Behavior package:

```bash
composer require cycle/entity-behavior
```

You can provide listeners as simple class-strings or as `[class, args]` tuples. You may also mix both forms in one array. Passing an empty args array `[]` is equivalent to specifying the class directly; the attribute normalizes this for you.

#### Simple listeners (class-strings only)

```php
<?php

use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;

#[EventListeners(listeners: [
    ChronosCreateListener::class,
    ChronosUpdateListener::class,
])]
final class User {}
```

#### Listeners with constructor arguments (mixed usage)

```php
<?php

use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;
use App\Cycle\Listener\AuditListener;

#[EventListeners(listeners: [
    ChronosSoftDeleteListener::class,
    [AuditListener::class, ['timezone' => 'UTC', 'captureOldValues' => true]],
])]
final class User {}
```

Example listener class consuming the named arguments:

```php
<?php

namespace App\Cycle\Listener;

final class AuditListener
{
    public function __construct(
        private readonly string $timezone = 'UTC',
        private readonly bool $captureOldValues = false,
    ) {}

    // Implement handle methods as required by Cycle ORM's listener contracts
}
```

For a complete entity example that uses listeners, see the annotated entity example below.

## Usage Examples

The package includes several example files in the `src/Example` directory that demonstrate how to use its features:

### Example Files

- **AnnotatedEntityWithAttributesExample.php**: Demonstrates how to create an entity with attributes for typecasting, using traits for UUID identifier and Chronos timestamps.
- **AnnotatedEntityWithTypecastHandlerExample.php**: Demonstrates how to create an entity using a custom `TypecastHandler` class.
- **ReadRepositoryExample.php**: Demonstrates how to create a read-only repository.
- **WriteRepositoryExample.php**: Shows how to create a repository with writing capabilities.

### Creating an Annotated Entity with Attribute Typecast

```php
<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosCreateTimestampTypecastTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosDeleteTimestampTypecastTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosUpdateTimestampTypecastTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasUuidIdentifierTypecastTrait;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;
use Vjik\CycleTypecast\AttributeTypecastHandler;

#[Entity(
    repository: WriteRepositoryExample::class,
    table: 'users',
    database: 'default',
    typecast: AttributeTypecastHandler::class,
)]
#[EventListeners(
    listeners: [
        ChronosCreateListener::class,
        ChronosUpdateListener::class,
        ChronosSoftDeleteListener::class,
    ],
)]
class AnnotatedEntityWithAttributesExample implements EntityInterface
{
    // Include the annotated traits (with attributes for typecasting)
    use HasUuidIdentifierTypecastTrait;
    use HasChronosCreateTimestampTypecastTrait;
    use HasChronosUpdateTimestampTypecastTrait;
    use HasChronosDeleteTimestampTypecastTrait;

    // Define additional properties with annotations
    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'string')]
    private string $email;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
```

### Creating an Annotated Entity with Typecast Handler

```php
<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosCreateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosDeleteTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosUpdateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasUuidIdentifierAnnotatedTrait;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;

#[Entity(
    repository: WriteRepositoryExample::class,
    table: 'users_with_handler',
    database: 'default',
    typecast: AnnotatedEntityExampleTypecastHandler::class,
)]
#[EventListeners(
    listeners: [
        ChronosCreateListener::class,
        ChronosUpdateListener::class,
        ChronosSoftDeleteListener::class,
    ],
)]
class AnnotatedEntityWithTypecastHandlerExample implements EntityInterface
{
    // Include the annotated traits (without attributes for typecasting)
    use HasUuidIdentifierAnnotatedTrait;
    use HasChronosCreateTimestampAnnotatedTrait;
    use HasChronosUpdateTimestampAnnotatedTrait;
    use HasChronosDeleteTimestampAnnotatedTrait;

    // Define additional properties with annotations
    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'string')]
    private string $email;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
```

### Creating a Write Repository

```php
<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\ORM\ORMInterface;
use DateTimeInterface;
use Sirix\Cycle\Extension\Factory\SelectFactory;
use Sirix\Cycle\Extension\Repository\AbstractWriteRepository;

class WriteRepositoryExample extends AbstractWriteRepository
{
    public function __construct(ORMInterface $orm, SelectFactory $selectFactory)
    {
        parent::__construct($orm, $selectFactory);
    }

    /**
     * Example of finding entities created after a certain date.
     */
    public function findUsersCreatedAfter(DateTimeInterface $date): array
    {
        $select = $this->select()
            ->where('createdAt', '>', $date->getTimestamp());

        return $select->fetchAll();
    }

    protected function getEntityClass(): string
    {
        return AnnotatedEntityWithAttributesExample::class;
    }
}
```

## Optional Dependencies

The package suggests the following dependencies for additional functionality:

- `cakephp/chronos`: Required for Chronos datetime support
- `cycle/annotated`: Required for annotated entity support
- `cycle/entity-behavior`: Required for entity behaviors and lifecycle hooks support
- `sirix/money`: Required for Money and Currency typecast support
- `vjik/cycle-typecast`: Required for Typecast support

## License

This package is licensed under the MIT License - see the LICENSE file for details.
