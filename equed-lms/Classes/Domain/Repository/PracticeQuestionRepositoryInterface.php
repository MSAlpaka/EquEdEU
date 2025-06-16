<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeQuestion;
use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface PracticeQuestionRepositoryInterface
{
    /**
     * @return PracticeQuestion[]
     */
    public function findAllActive(): array;

    /**
     * @param int $uid
     * @return PracticeQuestion|null
     */
    public function findByUid(int $uid): ?PracticeQuestion;

    /**
     * @param PracticeTest $practiceTest
     * @return PracticeQuestion[]
     */
    public function findByPracticeTest(PracticeTest $practiceTest): array;

    /**
     * @return QueryInterface<PracticeQuestion>
     */
    public function createQuery(): QueryInterface;
}

