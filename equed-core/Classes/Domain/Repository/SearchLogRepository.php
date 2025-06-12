<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\SearchLog;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Service\AuthorizationService;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for search logs.
 *
 * Repository zur Verwaltung der Suchprotokolle.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\SearchLog> */
class SearchLogRepository extends Repository
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
     * @return \Equed\EquedCore\Domain\Model\SearchLog[]
     */
    public function findAll(): array
    {
        if ($this->cache->has('equedcore_searchlog_findAll')) {
            return $this->cache->get('equedcore_searchlog_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_searchlog_findAll', $result, 3600);
        return $result;
    }

    /**
     * Find a log entry by its UID.
     *
     * @param int $uid
     * @return SearchLog|null
     */
    public function findByUid(int $uid): ?SearchLog
    {
        /** @var SearchLog|null $object */
        $object = parent::findByUid($uid);

        return $object;
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\SearchLog $object
     * @throws AccessDeniedException
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\SearchLog $object */
        parent::add($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\SearchLog $object
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\SearchLog $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\SearchLog $object
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\SearchLog $object */
        parent::remove($object);
    }
}
