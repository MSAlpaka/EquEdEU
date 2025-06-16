<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\ObservationTemplate;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface ObservationTemplateRepositoryInterface
{
    /**
     * @return ObservationTemplate[]
     */
    public function findAllActive(): array;

    /**
     * @param int $uid
     * @return ObservationTemplate|null
     */
    public function findByUid(int $uid): ?ObservationTemplate;

    /**
     * @param string $appliesTo
     * @return ObservationTemplate[]
     */
    public function findByAppliesTo(string $appliesTo): array;

    /**
     * @return QueryInterface<ObservationTemplate>
     */
    public function createQuery(): QueryInterface;
}

