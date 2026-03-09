<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Handler;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function array_key_exists;
use function array_keys;
use function in_array;

/**
 * Internal handler derived from and adapted after
 * vjik/cycle-typecast TypecastHandler (BSD-3-Clause).
 *
 * @see https://github.com/vjik/cycle-typecast
 */
abstract class TypecastHandler implements CastableInterface, UncastableInterface
{
    /** @var array<string, TypeInterface> */
    private readonly array $config;

    /** @var array<int, string> */
    private readonly array $supportedKeys;

    final public function __construct()
    {
        $this->config = $this->getConfig();
        $this->supportedKeys = array_keys($this->config);
    }

    final public function setRules(array $rules): array
    {
        foreach (array_keys($rules) as $key) {
            if (in_array($key, $this->supportedKeys, true)) {
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
    final public function cast(array $data): array
    {
        foreach ($this->config as $column => $type) {
            if (array_key_exists($column, $data)) {
                $data[$column] = $type->convertToPhpValue(
                    $data[$column],
                    new CastContext($column, $data),
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
    final public function uncast(array $data): array
    {
        foreach ($this->config as $column => $type) {
            if (array_key_exists($column, $data)) {
                $data[$column] = $type->convertToDatabaseValue(
                    $data[$column],
                    new UncastContext($column, $data),
                );
            }
        }

        return $data;
    }

    /**
     * @return array<string, TypeInterface>
     */
    abstract protected function getConfig(): array;
}
