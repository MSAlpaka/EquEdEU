<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CertificateTemplate;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CertificateTemplateRepositoryInterface
{
    /**
     * @param string $badgeLevel
     * @return CertificateTemplate[]
     */
    public function findByBadgeLevel(string $badgeLevel): array;

    /**
     * @param string $language
     * @return CertificateTemplate[]
     */
    public function findByLanguage(string $language): array;

    /**
     * @return QueryInterface<CertificateTemplate>
     */
    public function createQuery(): QueryInterface;
}
