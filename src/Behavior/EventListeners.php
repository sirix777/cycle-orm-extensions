<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Behavior;

use Attribute;
use Cycle\ORM\SchemaInterface;
use Cycle\Schema\Registry;
use Cycle\Schema\SchemaModifierInterface;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_CLASS), NamedArgumentConstructor]
final class EventListeners implements SchemaModifierInterface
{
    /**
     * @param class-string[] $listeners
     */
    public function __construct(private readonly array $listeners) {}

    public function compute(Registry $registry): void {}

    public function render(Registry $registry): void {}

    /**
     * @param array<int|string, mixed> $schema
     */
    public function modifySchema(array &$schema): void
    {
        foreach ($this->listeners as $listener) {
            $schema[SchemaInterface::LISTENERS][] = $listener;
        }
    }

    final public function withRole(string $role): static
    {
        return clone $this;
    }
}
