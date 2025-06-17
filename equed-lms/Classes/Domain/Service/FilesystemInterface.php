<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Abstraction for basic filesystem operations.
 */
interface FilesystemInterface
{
    /**
     * Check whether the given path exists.
     */
    public function exists(string $path): bool;

    /**
     * Create directories.
     *
     * @param string|array<int,string> $dirs Path or paths to create
     * @param int                      $mode Permissions for new directories
     */
    public function mkdir(string|array $dirs, int $mode = 0777): void;

    /**
     * Dump the given content into a file.
     */
    public function dumpFile(string $path, string $content): void;

    /**
     * Remove files or directories.
     *
     * @param string|array<int,string> $paths Paths to remove
     */
    public function remove(string|array $paths): void;

    /**
     * Get the size of a file in bytes.
     *
     * @throws \RuntimeException When the size cannot be determined
     */
    public function fileSize(string $path): int;
}
