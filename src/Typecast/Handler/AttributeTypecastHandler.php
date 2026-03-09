<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Handler;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;
use Cycle\ORM\SchemaInterface;
use ReflectionAttribute;
use ReflectionClass;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function array_keys;
use function class_exists;
use function is_string;

/**
 * Internal attribute handler derived from and adapted after
 * vjik/cycle-typecast AttributeTypecastHandler (BSD-3-Clause).
 *
 * @see https://github.com/vjik/cycle-typecast
 */
final class AttributeTypecastHandler implements CastableInterface, UncastableInterface
{
    /** @var array<string, TypeInterface> */
    private array $types = [];

    public function __construct(SchemaInterface $schema, string $role)
    {
        $entityClass = $schema->define($role, SchemaInterface::ENTITY);
        if (is_string($entityClass) && class_exists($entityClass)) {
            $reflection = new ReflectionClass($entityClass);
            foreach ($reflection->getProperties() as $property) {
                $attributes = $property->getAttributes(TypeInterface::class, ReflectionAttribute::IS_INSTANCEOF);
                if (empty($attributes)) {
                    continue;
                }

                $this->types[$property->getName()] = $attributes[0]->newInstance();
            }
        }
    }

    public function setRules(array $rules): array
    {
        foreach (array_keys($rules) as $key) {
            if (isset($this->types[$key])) {
                unset($rules[$key]);
            }
        }

        return $rules;
    }

    /**
     * @param array<non-empty-string, mixed> $data
     *
     * @return array<non-empty-string, mixed>
     */
    public function cast(array $data): array
    {
        foreach ($data as $key => $value) {
            if (isset($this->types[$key])) {
                $data[$key] = $this->types[$key]->convertToPhpValue(
                    $value,
                    new CastContext($key, $data),
                );
            }
        }

        return $data;
    }

    /**
     * @param array<non-empty-string, mixed> $data
     *
     * @return array<non-empty-string, mixed>
     */
    public function uncast(array $data): array
    {
        foreach ($data as $key => $value) {
            if (isset($this->types[$key])) {
                $data[$key] = $this->types[$key]->convertToDatabaseValue(
                    $value,
                    new UncastContext($key, $data),
                );
            }
        }

        return $data;
    }
}
