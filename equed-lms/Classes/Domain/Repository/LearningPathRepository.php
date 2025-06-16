<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Model\LearningPath;

/**
 * Repository for LearningPath entities.
 *
 * @extends Repository<LearningPath>
 */

final class LearningPathRepository extends Repository implements LearningPathRepositoryInterface
{
    /**
     * Default ordering: first by level, then by title.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'level' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * {@inheritDoc}
     *
     * @return LearningPath[]
     */
    public function findCompletedWithoutBadge(): array
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select('DISTINCT lp.uid')
            ->from('tx_equedlms_domain_model_learningpath', 'lp')
            ->join('lp', 'tx_equedlms_domain_model_course', 'c', 'c.learning_path = lp.uid')
            ->join('c', 'tx_equedlms_domain_model_courseinstance', 'ci', 'ci.courseprogram = c.courseprogram')
            ->join('ci', 'tx_equedlms_domain_model_usercourserecord', 'ucr', 'ucr.course_instance = ci.uid AND ucr.completed_at IS NOT NULL')
            ->leftJoin(
                'lp',
                'tx_equedlms_domain_model_badgeaward',
                'ba',
                "ba.badge_type = 'learning_path' AND ba.badge_code = lp.uid AND ba.frontend_user = ucr.fe_user"
            )
            ->where($qb->expr()->isNull('ba.uid'));

        $pathUids = $qb->executeQuery()->fetchFirstColumn();

        if ($pathUids === []) {
            return [];
        }

        $query = $this->createQuery();
        $query->matching($query->in('uid', array_map('intval', $pathUids)));

        return $query->execute()->toArray();
    }
}
