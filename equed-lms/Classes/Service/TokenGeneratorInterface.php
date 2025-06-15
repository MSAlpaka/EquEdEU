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
     *
     * @param int $length Number of bytes to generate
     * @return string Random binary string
     */
    public function generate(int $length): string;
}
