<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

/**
 * Protokoll der Suchanfragen.
 * Search log entries.
 *
 * @author EEE
 * @version 1.0.0
 * @changed 2025-06-06
 *
 * @Extbase\ORM\Mapping\Entity
 */
class SearchLog extends AbstractEntity implements DomainObjectInterface
{
    /**
     * @var int
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $crdate;

    /**
     * @var int
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $tstamp;

    /**
     * @var bool
     * @Extbase\ORM\Mapping\Column(type="boolean")
     */
    protected bool $deleted = false;

    /**
     * @var bool
     * @Extbase\ORM\Mapping\Column(type="boolean")
     */
    protected bool $hidden = false;

    /**
     * @var string $searchTerm // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $searchTerm;

    /**
     * @var int $userId // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $userId;

    /**
     * @var int $searchDate // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $searchDate;

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function getPid(): ?int
    {
        return $this->pid;
    }

    public function setPid(int $pid): void
    {
        $this->pid = $pid;
    }

    public function getCrdate(): int
    {
        return $this->crdate;
    }

    public function setCrdate(int $crdate): self
    {
        $this->crdate = $crdate;
        return $this;
    }

    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    public function setTstamp(int $tstamp): self
    {
        $this->tstamp = $tstamp;
        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    public function getSearchTerm(): string
    {
        return $this->searchTerm;
    }

    public function setSearchTerm(string $searchTerm): self
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getSearchDate(): int
    {
        return $this->searchDate;
    }

    public function setSearchDate(int $searchDate): self
    {
        $this->searchDate = $searchDate;
        return $this;
    }
}
