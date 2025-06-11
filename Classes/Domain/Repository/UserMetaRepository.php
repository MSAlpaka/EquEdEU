<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\UserMeta;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Service\AuthorizationService;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for user meta data.
 *
 * Repository zur Verwaltung von Nutzer-Metadaten.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\UserMeta> */
class UserMetaRepository extends Repository
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
     * @return \Equed\EquedCore\Domain\Model\UserMeta[]
     */
    public function findAll(): array
    {
        if ($this->cache->has('equedcore_usermeta_findAll')) {
            return $this->cache->get('equedcore_usermeta_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_usermeta_findAll', $result, 3600);
        return $result;
    }

    /**
     * @param mixed $uid
     * @return \Equed\EquedCore\Domain\Model\UserMeta|null
     */
    public function findByUid($uid)
    {
        /** @var \Equed\EquedCore\Domain\Model\UserMeta|null $result */
        $result = parent::findByUid($uid);
        return $result;
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\UserMeta $object
     * @throws AccessDeniedException
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\UserMeta $object */
        parent::add($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\UserMeta $object
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\UserMeta $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\UserMeta $object
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\UserMeta $object */
        parent::remove($object);
    }
}
