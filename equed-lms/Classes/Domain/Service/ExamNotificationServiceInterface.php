<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface ExamNotificationServiceInterface
{
    public function notifyAll(): int;
}
