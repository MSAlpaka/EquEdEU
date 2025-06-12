<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Submission;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Submission entities.
 *
 * @extends Repository<Submission>
 */
class SubmissionRepository extends Repository implements SubmissionRepositoryInterface
{
    /**
     * Default ordering: newest first by creation date.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * {@inheritDoc}
     */
    public function findByUid(int $uid): ?Submission
    {
        /** @var Submission|null $submission */
        $submission = parent::findByUid($uid);

        return $submission;
    }

    /**
     * {@inheritDoc}
     */
    public function findPendingForWeeklyAnalysis(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('gptAnalysisStatus', 'pending')
        );

        return $query->execute()->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function findPendingForEvaluation(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('gptAnalysisStatus', 'pending')
        );

        return $query->execute()->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function update(Submission $submission): void
    {
        parent::update($submission);
    }

    /**
     * {@inheritDoc}
     */
    public function findByUserCourseRecord(int $userCourseRecordUid): array
    {
        $queryBuilder = $this->createQuery()->getQueryBuilder();
        $queryBuilder->resetQueryParts();
        $queryBuilder
            ->select('us.points_awarded AS points', 'us.max_points AS maxPoints')
            ->from('tx_equedlms_domain_model_usersubmission', 'us')
            ->join(
                'us',
                'tx_equedlms_domain_model_usercourserecord',
                'ucr',
                'ucr.uid = :ucrUid AND us.course_instance = ucr.course_instance AND us.frontend_user = ucr.fe_user'
            )
            ->setParameter('ucrUid', $userCourseRecordUid, \PDO::PARAM_INT);

        $rows = $queryBuilder->executeQuery()->fetchAllAssociative();

        return array_map(
            static function (array $row): array {
                return [
                    'points'    => isset($row['points']) ? (float) $row['points'] : null,
                    'maxPoints' => isset($row['maxPoints']) ? (float) $row['maxPoints'] : null,
                ];
            },
            $rows
        );
    }
}
// EOF
