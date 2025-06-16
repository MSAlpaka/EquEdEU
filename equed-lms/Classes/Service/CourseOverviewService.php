<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Repository\CourseProgramRepositoryInterface;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseOverviewServiceInterface;

/**
 * Default implementation for assembling course overview data.
 */
final class CourseOverviewService implements CourseOverviewServiceInterface
{
    public function __construct(
        private readonly CourseProgramRepositoryInterface $programRepository,
        private readonly CourseInstanceRepositoryInterface $instanceRepository,
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getAvailablePrograms(): array
    {
        return $this->programRepository->findActive();
    }

    /**
     * @inheritDoc
     */
    public function getActiveInstances(): array
    {
        $now = new DateTimeImmutable();

        $query = $this->instanceRepository->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('isVisible', true),
                $query->equals('isArchived', false),
                $query->lessThanOrEqual('startDate', $now),
                $query->greaterThanOrEqual('endDate', $now),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getMyCourses(int $userId): array
    {
        return $this->recordRepository->findByUserId($userId);
    }

    /**
     * @inheritDoc
     */
    public function getCourseOverview(int $userId): array
    {
        return [
            'availablePrograms' => $this->getAvailablePrograms(),
            'activeInstances'   => $this->getActiveInstances(),
            'myCourses'         => $this->getMyCourses($userId),
        ];
    }
}

