<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Repository;

use Equed\EquedCore\Domain\Model\DocumentUpload;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Psr\SimpleCache\CacheInterface;
use Equed\EquedCore\Service\AuthorizationService;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

/**
 * Repository for document uploads.
 *
 * Repository zur Verwaltung hochgeladener Dokumente.
 *
 * @author Equed Team
 * @version 1.0.0
 */
/** @extends Repository<\Equed\EquedCore\Domain\Model\DocumentUpload> */
class DocumentUploadRepository extends Repository
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
     * @return \Equed\EquedCore\Domain\Model\DocumentUpload[]
     */
    public function findAll(): array
    {
        if ($this->cache->has('equedcore_documentupload_findAll')) {
            return $this->cache->get('equedcore_documentupload_findAll');
        }
        $query = $this->createQuery();
        $result = $query->execute()->toArray();
        $this->cache->set('equedcore_documentupload_findAll', $result, 3600);
        return $result;
    }

    /**
     * @param mixed $uid
     * @return DocumentUpload|null
     */
    public function findByUid($uid)
    {
        /** @var \Equed\EquedCore\Domain\Model\DocumentUpload|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }

    /**
     * @throws AccessDeniedException
     * @param \Equed\EquedCore\Domain\Model\DocumentUpload $object
     */
    public function add($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\DocumentUpload $object */
        if (!$this->authorizationService->isInstructor()) {
            throw new AccessDeniedException(
                'Nur Instructor darf Dokumente hochladen.',
                1612345679
            );
        }
        if (isset($this->persistenceManager)) {
            parent::add($object);
        }
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\DocumentUpload $object
     */
    public function update($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\DocumentUpload $object */
        parent::update($object);
    }

    /**
     * @param \Equed\EquedCore\Domain\Model\DocumentUpload $object
     */
    public function remove($object): void
    {
        /** @var \Equed\EquedCore\Domain\Model\DocumentUpload $object */
        parent::remove($object);
    }
}
