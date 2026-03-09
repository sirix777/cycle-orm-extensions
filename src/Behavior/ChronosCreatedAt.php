<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Behavior;

use Attribute;
use Cycle\ORM\SchemaInterface;
use Cycle\Schema\Registry;
use Cycle\Schema\SchemaModifierInterface;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;

use function array_key_exists;
use function is_array;

#[Attribute(Attribute::TARGET_CLASS), NamedArgumentConstructor]
final readonly class ChronosCreatedAt implements SchemaModifierInterface
{
    public function __construct(private string $field = 'createdAt', private ?string $column = null) {}

    public function compute(Registry $registry): void {}

    public function render(Registry $registry): void {}

    /**
     * @param array<int|string, mixed> $schema
     */
    public function modifySchema(array &$schema): void
    {
        if (
            null !== $this->column
            && isset($schema[SchemaInterface::COLUMNS])
            && is_array($schema[SchemaInterface::COLUMNS])
            && array_key_exists($this->field, $schema[SchemaInterface::COLUMNS])
        ) {
            $schema[SchemaInterface::COLUMNS][$this->field] = $this->column;
        }

        $schema[SchemaInterface::LISTENERS][] = [ChronosCreateListener::class, ['field' => $this->field]];
    }

    final public function withRole(string $role): static
    {
        return clone $this;
    }
}
