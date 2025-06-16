<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\QmsCase;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface QmsCaseRepositoryInterface
{
    /**
     * @return QmsCase[]
     */
    public function findOpenCases(): array;

    /**
     * @param FrontendUser $instructor
     * @return QmsCase[]
     */
    public function findByInstructor(FrontendUser $instructor): array;

    /**
     * @return QmsCase[]
     */
    public function findEscalatedCases(): array;

    /**
     * @param FrontendUser $user
     * @return QmsCase[]
     */
    public function findByUser(FrontendUser $user): array;

    /**
     * @return QueryInterface<QmsCase>
     */
    public function createQuery(): QueryInterface;
}

