<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\Country;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Service\AuthorizationService;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for country records.
 *
 * Repository zur Verwaltung der Länder.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\Country> */
final class CountryRepository extends Repository
{
    protected CacheInterface $cache;

    protected AuthorizationService $authorizationService;

    public function __construct(
        CacheInterface $cache,
        AuthorizationService $authorizationService
    ) {
        parent::__construct();
        $this->cache = $cache;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @return \Equed\EquedCore\Domain\Model\Country[]
     */
    public function findAll(): array
    {
        if ($this->cache->has('equedcore_country_findAll')) {
            return $this->cache->get('equedcore_country_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_country_findAll', $result, 3600);
        return $result;
    }

    /**
     * Find a country by UID.
     *
     * @param int $uid
     * @return Country|null
     */
    public function findByUid(int $uid): ?Country
    {
        /** @var Country|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\Country $object
     * @throws AccessDeniedException
     * @return void
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\Country $object */
        parent::add($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\Country $object
     * @return void
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\Country $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\Country $object
     * @return void
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\Country $object */
        parent::remove($object);
    }
}
