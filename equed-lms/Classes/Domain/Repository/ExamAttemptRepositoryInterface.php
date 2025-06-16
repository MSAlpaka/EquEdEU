<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\ExamAttempt;
use Equed\EquedLms\Domain\Model\ExamTemplate;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface ExamAttemptRepositoryInterface
{
    /**
     * @param FrontendUser $frontendUser
     * @param ExamTemplate $template
     * @return ExamAttempt[]
     */
    public function findByUserAndTemplate(FrontendUser $frontendUser, ExamTemplate $template): array;

    /**
     * @param FrontendUser $frontendUser
     * @return ExamAttempt[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array;

    /**
     * @return QueryInterface<ExamAttempt>
     */
    public function createQuery(): QueryInterface;
}

