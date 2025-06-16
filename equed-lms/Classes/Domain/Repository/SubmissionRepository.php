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
final class SubmissionRepository extends Repository implements SubmissionRepositoryInterface
{
    /**
     * Default ordering: newest first by creation date.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * {@inheritDoc}
     *
     * @param int $uid
     * @return Submission|null
     */
    public function findByUid(int $uid): ?Submission
    {
        /** @var Submission|null $submission */
        $submission = parent::findByUid($uid);

        return $submission;
    }

    /**
     * {@inheritDoc}
     *
     * @return Submission[]
     */
    public function findPendingForAnalysis(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('gptAnalysisStatus', 'pending')
        );

        return $query->execute()->toArray();
    }

    /**
     * {@inheritDoc}
     *
     * @param Submission $submission
     * @return void
     */
    public function update(Submission $submission): void
    {
        parent::update($submission);
    }

}
