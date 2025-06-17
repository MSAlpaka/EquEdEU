<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\FilesystemInterface;
use Symfony\Component\Filesystem\Filesystem;
use RuntimeException;

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

    public function fileSize(string $path): int
    {
        $size = @filesize($path);
        if ($size === false) {
            throw new RuntimeException(sprintf('Unable to read file size for "%s".', $path));
        }

        return $size;
    }
}
