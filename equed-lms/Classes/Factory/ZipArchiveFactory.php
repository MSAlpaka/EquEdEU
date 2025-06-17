<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use ZipArchive;

final class ZipArchiveFactory
{
    public function __invoke(): ZipArchive
    {
        return new ZipArchive();
    }
}
