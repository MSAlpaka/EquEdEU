<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Contract for generating secure random tokens.
 */
interface TokenGeneratorInterface
{
    /**
     * Generate a random string of the given length in bytes.
     */
    public function generate(int $length): string;
}
