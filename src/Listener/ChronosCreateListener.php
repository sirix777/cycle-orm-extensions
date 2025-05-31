<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Listener;

use Cake\Chronos\Chronos;
use Cycle\ORM\Entity\Behavior\Attribute\Listen;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command\OnCreate;

final class ChronosCreateListener
{
    public function __construct(private readonly string $field = 'createdAt') {}

    #[Listen(OnCreate::class)]
    public function __invoke(OnCreate $event): void
    {
        $event->state->register($this->field, Chronos::instance($event->timestamp));
    }
}
