<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\ExternalCertificate;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for external certificates.
 *
 * Repository zur Verwaltung externer Zertifikate.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\ExternalCertificate> */
final class ExternalCertificateRepository extends Repository
{
    protected CacheInterface $cache;

    protected AuthorizationServiceInterface $authorizationService;

    public function __construct(
        CacheInterface $cache,
        AuthorizationServiceInterface $authorizationService
    ) {
        parent::__construct();
        $this->cache = $cache;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @return \Equed\EquedCore\Domain\Model\ExternalCertificate[]
     */
    public function findAll(): array
    {
        if ($this->cache->has('equedcore_externalcertificate_findAll')) {
            return $this->cache->get('equedcore_externalcertificate_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_externalcertificate_findAll', $result, 3600);
        return $result;
    }

    /**
     * Find an external certificate by UID.
     *
     * @param int $uid
     * @return ExternalCertificate|null
     */
    public function findByUid(int $uid): ?ExternalCertificate
    {
        /** @var ExternalCertificate|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\ExternalCertificate $object
     * @throws AccessDeniedException
     * @return void
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\ExternalCertificate $object */
        parent::add($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\ExternalCertificate $object
     * @return void
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\ExternalCertificate $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\ExternalCertificate $object
     * @return void
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\ExternalCertificate $object */
        parent::remove($object);
    }
}
