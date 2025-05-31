# Cycle ORM Extensions

Practical extensions for Cycle ORM: base repositories, entity traits, typecasts, and more.

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

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

### Repositories

Base repository implementations for common operations:

- `AbstractReadRepository` - Base repository for read-only operations
- `AbstractWriteRepository` - Base repository for read-write operations

### Typecasts

Custom typecasts for various data types:

- Array typecasts
- Boolean typecasts
- Chronos datetime typecasts
- Currency typecasts
- CurrencyCode typecasts
- Money typecasts
- UUID typecasts

## Usage Examples

The package includes several example files in the `src/Example` directory that demonstrate how to use its features:

### Example Files

- **AnnotatedEntityExample.php**: Demonstrates how to create an entity with annotations, using traits for UUID identifier and Chronos timestamps, and configuring event listeners.
- **AnnotatedEntityExampleTypecastHandler.php**: Shows how to create a typecast handler for Chronos datetime fields.
- **ReadRepositoryExample.php**: Demonstrates how to create a read-only repository.
- **WriteRepositoryExample.php**: Shows how to create a repository with writing capabilities.

### Creating an Annotated Entity

```php
<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Contract\EntityInterface;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosCreateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosUpdateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasUuidIdentifierAnnotatedTrait;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;

#[Entity(
    repository: WriteRepositoryExample::class,
    table: 'users',
    database: 'default',
    typecast: [
        AnnotatedEntityExampleTypecastHandler::class
    ]
)]
#[EventListeners(
    listeners: [
        ChronosCreateListener::class,
        ChronosUpdateListener::class,
        ChronosSoftDeleteListener::class,
    ],
)]
class AnnotatedEntityExample implements EntityInterface
{
    // Include the annotated traits
    use HasUuidIdentifierAnnotatedTrait;
    use HasChronosCreateTimestampAnnotatedTrait;
    use HasChronosUpdateTimestampAnnotatedTrait;

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

### Creating a Typecast Handler

```php
<?php

namespace Sirix\Cycle\Extension\Example;

use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;
use Vjik\CycleTypecast\TypecastHandler;

class AnnotatedEntityExampleTypecastHandler extends TypecastHandler
{
    protected function getConfig(): array
    {
       return [
           'createdAt' => new ChronosToTimestampType(),
           'updatedAt' => new ChronosToTimestampType(),
           'deletedAt' => new ChronosToTimestampType(),
       ];
    }
}
```

### Creating a Write Repository

```php
<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\ORM\Select\Repository;
use DateTimeInterface;
use Sirix\Cycle\Extension\Repository\AbstractWriteRepository;

/**
 * @extends Repository<AnnotatedEntityExample>
 */
class WriteRepositoryExample extends AbstractWriteRepository
{
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
        return AnnotatedEntityExample::class;
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
