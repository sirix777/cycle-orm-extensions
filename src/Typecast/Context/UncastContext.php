<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Context;

/**
 * Internal context object derived from and adapted after
 * vjik/cycle-typecast (BSD-3-Clause).
 *
 * @see https://github.com/vjik/cycle-typecast
 */
final readonly class UncastContext
{
    /**
     * @param array<non-empty-string, mixed> $data
     */
    public function __construct(public string $property, public array $data) {}
}
