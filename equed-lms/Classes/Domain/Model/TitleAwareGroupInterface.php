<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

/**
 * Interface for user group models that expose a title.
 */
interface TitleAwareGroupInterface
{
    public function getTitle(): string;
}
