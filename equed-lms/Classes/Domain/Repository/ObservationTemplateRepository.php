<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\ObservationTemplate;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\ObservationTemplateRepositoryInterface;

/**
 * Repository for ObservationTemplate entities.

 *
 * @extends Repository<ObservationTemplate>
 */
final class ObservationTemplateRepository extends Repository implements ObservationTemplateRepositoryInterface
{
    /**
     * Finds all active templates (deleted flag is false).
     *
     * @return ObservationTemplate[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Find a template by its unique identifier.
     *
     * @param int $uid
     * @return ObservationTemplate|null
     */
    public function findByUid(int $uid): ?ObservationTemplate
    {
        return $this->findByIdentifier($uid);
    }

    /**
     * Finds all templates applicable to a given context (lesson, submission, course).
     *
     * @param string $appliesTo
     * @return ObservationTemplate[]
     */
    public function findByAppliesTo(string $appliesTo): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('appliesTo', $appliesTo)
        );

        return $query->execute()->toArray();
    }
}
