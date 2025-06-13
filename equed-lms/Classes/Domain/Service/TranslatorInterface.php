<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface TranslatorInterface
{
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string;
}
