<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonAttempt;

interface LessonAttemptRepositoryInterface
{
    public function findLatestByUserAndLesson(FrontendUser $user, Lesson $lesson): ?LessonAttempt;

    /**
     * @return LessonAttempt[]
     */
    public function findAllUnfinished(): array;

    /**
     * @param FrontendUser $user
     * @return LessonAttempt[]
     */
    public function findByFeUser(FrontendUser $user): array;
}
