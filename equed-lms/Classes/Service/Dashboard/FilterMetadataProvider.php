<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Dashboard;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;

/**
 * Provides filter option metadata for the dashboard.
 */
final class FilterMetadataProvider
{
    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepo,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepo,
    ) {
    }

    /**
     * Collect available filter values.
     *
     * @return array<string,mixed>
     */
    public function getMetadata(): array
    {
        return [
            'theme'       => $this->courseInstanceRepo->findDistinctField('theme'),
            'language'    => $this->courseInstanceRepo->findDistinctField('language'),
            'badgeStatus' => $this->userCourseRecordRepo->findDistinctField('badgeStatus'),
            'eqfLevel'    => $this->courseInstanceRepo->findDistinctField('eqfLevel'),
        ];
    }
}
