<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CertificateTemplate;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\CertificateTemplateRepositoryInterface;

/**
 * Repository for CertificateTemplate entities.

 *
 * @extends Repository<CertificateTemplate>
 */
final class CertificateTemplateRepository extends Repository implements CertificateTemplateRepositoryInterface
{
    /**
     * Finds all certificate templates matching a badge level.
     *
     * @param string $badgeLevel
     * @return CertificateTemplate[]
     */
    public function findByBadgeLevel(string $badgeLevel): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('badgeLevel', $badgeLevel)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all templates for a given language code.
     *
     * @param string $language
     * @return CertificateTemplate[]
     */
    public function findByLanguage(string $language): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('language', $language)
        );

        return $query->execute()->toArray();
    }
}
