<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Sirix\Cycle\Extension\Behavior\EventListeners;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosCreateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosUpdateTimestampAnnotatedTrait;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasUuidIdentifierAnnotatedTrait;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;

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
    typecast: [
        AnnotatedEntityExampleTypecastHandler::class,
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
