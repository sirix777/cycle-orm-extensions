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
use Sirix\Cycle\Extension\Typecast\Handler\AttributeTypecastHandler;

/**
 * Example of using annotated traits with Cycle ORM.
 *
 * This example demonstrates how to use the annotated traits to create
 * a fully annotated entity for use with Cycle ORM.
 *
 * The annotated traits include the appropriate Cycle ORM annotations
 * for the properties they define, making it easy to create entities
 * that work with Cycle ORM's annotation-based mapping.
 *
 * @see https://cycle-orm.dev/docs/annotated-entity/current/en
 */
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
    // Include the annotated traits
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
