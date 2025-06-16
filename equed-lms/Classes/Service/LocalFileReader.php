<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\FileReaderInterface;

/**
 * Default file reader using PHP's file_get_contents.
 */
final class LocalFileReader implements FileReaderInterface
{
    public function read(string $path): string|false
    {
        return file_get_contents($path);
    }
}
