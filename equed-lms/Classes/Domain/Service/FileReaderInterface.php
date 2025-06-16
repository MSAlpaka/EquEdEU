<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Abstraction to read file contents.
 */
interface FileReaderInterface
{
    /**
     * Read the contents of the given file path.
     *
     * @param string $path Absolute file path
     * @return string|false File contents or false on failure
     */
    public function read(string $path): string|false;
}
