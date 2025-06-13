<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\UserCourseStatus;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Equed\EquedLms\Domain\Service\ClockInterface;

/**
 * Service for retrieving and formatting user progress data.
 */
final class ProgressService implements ProgressServiceInterface
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly LanguageServiceInterface $languageService,
        private readonly ConnectionPool $connectionPool,
        private readonly ClockInterface $clock
    ) {
    }

    /**
     * Returns overall and per-course progress for the given user.
     *
     * @param int|FrontendUser $user FE user ID or object
     * @return array{
     *   overallPercent: int,
     *   courses: array<int, array{
     *     courseId: int|null,
     *     courseTitle: string|null,
     *     progress: int,
     *     status: string
     *   }>
     * }
     */
    public function getProgressDataForUser(int|FrontendUser $user): array
    {
        $userId = $user instanceof FrontendUser ? (int)$user->getUid() : $user;
        $records = $this->userCourseRecordRepository->findByUserId($userId);
        $total = count($records);
        $sum = 0;
        $courses = [];

        foreach ($records as $record) {
            $progress = (int) round($record->getProgressPercent());
            $sum += $progress;

            /** @var CourseInstance $instance */
            $instance = $record->getCourseInstance();
            /** @var CourseProgram|null $program */
            $program = $instance->getCourseProgram();

            $courses[] = [
                'courseId'    => $program?->getUid(),
                'courseTitle' => $instance->getTitle(),
                'progress'    => $progress,
                'status'      => $this->languageService->translate(
                    match ($record->getStatus()->value) {
                        'completed'   => 'status.completed',
                        'inProgress'  => 'status.inProgress',
                        default       => 'status.notStarted',
                    }
                ),
            ];
        }

        $overall = $total > 0 ? (int) round($sum / $total) : 0;

        return [
            'overallPercent' => $overall,
            'courses'        => $courses,
        ];
    }

    public function cleanupAbandonedCourseProgress(int $days): void
    {
        $cutoff = $this->clock->now()
            ->modify(sprintf('-%d days', $days))
            ->format('Y-m-d H:i:s');

        /** @var QueryBuilder $qb */
        $qb = $this->connectionPool
            ->getConnectionForTable('tx_equedlms_domain_model_usercourserecord')
            ->createQueryBuilder();

        $qb
            ->delete('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->lt('last_activity', $qb->createNamedParameter($cutoff)),
                $qb->expr()->eq('status', $qb->createNamedParameter(UserCourseStatus::InProgress->value))
            )
            ->executeStatement();
    }
}
