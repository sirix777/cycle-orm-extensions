<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Listener;

use Cake\Chronos\Chronos;
use Cycle\ORM\Command\StoreCommand;
use Cycle\ORM\Entity\Behavior\Attribute\Listen;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command\OnDelete;
use Cycle\ORM\Heap\Node;

final class ChronosSoftDeleteListener
{
    public function __construct(private readonly string $field = 'deletedAt') {}

    #[Listen(OnDelete::class)]
    public function __invoke(OnDelete $event): void
    {
        $event->state->register($this->field, Chronos::instance($event->timestamp));

        // Replace Delete command to Store command
        if (! $event->command instanceof StoreCommand) {
            $event->command = $event->mapper->queueUpdate($event->entity, $event->node, $event->state);
        }

        // Node should be removed from heap
        $event->state->setStatus(Node::SCHEDULED_DELETE);
    }
}
