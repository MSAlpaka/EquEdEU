<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Default token generator using PHP's random_bytes.
 */
final class RandomTokenGenerator implements TokenGeneratorInterface
{
    /**
     * {@inheritDoc}
     *
     * @return string Random token bytes
     */
    public function generate(int $length): string
    {
        return random_bytes($length);
    }
}
