<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\AuditLog;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for audit log entries.
 *
 * Repository zur Verwaltung der Audit-Logs.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\AuditLog> */
final class AuditLogRepository extends Repository
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
     * @return \Equed\EquedCore\Domain\Model\AuditLog[]
     *
     * @throws AccessDeniedException
     */
    public function findAll(): array
    {
        if (!$this->authorizationService->isCertifier() && !$this->authorizationService->isServiceCenter()) {
            throw new AccessDeniedException(
                'Nur Certifier oder ServiceCenter dürfen alle Logs sehen.',
                1612345678
            );
        }
        if ($this->cache->has('equedcore_auditlog_findAll')) {
            return $this->cache->get('equedcore_auditlog_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_auditlog_findAll', $result, 3600);
        return $result;
    }

    /**
     * Find an audit log entry by UID.
     *
     * @param int $uid
     * @return AuditLog|null
     */
    public function findByUid(int $uid): ?AuditLog
    {
        /** @var AuditLog|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\AuditLog $object
     * @return void
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\AuditLog $object */
        parent::add($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\AuditLog $object
     * @return void
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\AuditLog $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\AuditLog $object
     * @return void
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\AuditLog $object */
        parent::remove($object);
    }
}
