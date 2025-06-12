<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\ExamAttempt;
use Equed\EquedLms\Domain\Model\ExamTemplate;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for ExamAttempt entities.

 *
 * @extends Repository<ExamAttempt>
 */
final class ExamAttemptRepository extends Repository
{
    /**
     * Find all attempts by a specific user for the provided exam template.
     *
     * @param FrontendUser $frontendUser Frontend user entity
     * @param ExamTemplate $template     Exam template entity
     *
     * @return ExamAttempt[]
     */
    public function findByUserAndTemplate(FrontendUser $frontendUser, ExamTemplate $template): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('frontendUser', $frontendUser),
                $query->equals('examTemplate', $template),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all attempts by a specific frontend user.
     *
     * @param FrontendUser $frontendUser
     * @return ExamAttempt[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('frontendUser', $frontendUser)
        );

        return $query->execute()->toArray();
    }

}
// EOF
