<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\FilesystemInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Filesystem implementation using Symfony's component.
 */
final class SymfonyFilesystem implements FilesystemInterface
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    public function exists(string $path): bool
    {
        return $this->filesystem->exists($path);
    }

    public function mkdir(string|array $dirs, int $mode = 0777): void
    {
        $this->filesystem->mkdir($dirs, $mode);
    }

    public function dumpFile(string $path, string $content): void
    {
        $this->filesystem->dumpFile($path, $content);
    }

    public function remove(string|array $paths): void
    {
        $this->filesystem->remove($paths);
    }
}
