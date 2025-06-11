<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Dokumentenupload zu Zertifizierungen.
 * Document upload for certifications.
 *
 * @author EEE
 * @version 1.0.0
 * @changed 2025-06-06
 *
 * @Extbase\ORM\Mapping\Entity
 */
class DocumentUpload extends AbstractEntity implements DomainObjectInterface
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
     * @var FileReference|null $fileReference // Instructor, Certifier
     */
    protected ?FileReference $fileReference = null;

    /**
     * @var int $uploadedBy // Nur Instructor oder Certifier
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $uploadedBy;

    /**
     * @var int $uploadDate // Instructor, Certifier
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $uploadDate;

    /**
     * @var bool $isCertified
     * @Extbase\ORM\Mapping\Column(type="boolean")
     */
    protected bool $isCertified = false;

    public function onCertificationUpload(): void
    {
        // QMS-Hook: Verarbeitung nach Upload
    }

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

    public function getFileReference(): ?FileReference
    {
        return $this->fileReference;
    }

    public function setFileReference(?FileReference $fileReference): self
    {
        $this->fileReference = $fileReference;
        return $this;
    }

    public function getUploadedBy(): int
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(int $uploadedBy): self
    {
        $this->uploadedBy = $uploadedBy;
        return $this;
    }

    public function getUploadDate(): int
    {
        return $this->uploadDate;
    }

    public function setUploadDate(int $uploadDate): self
    {
        $this->uploadDate = $uploadDate;
        return $this;
    }

    public function isCertified(): bool
    {
        return $this->isCertified;
    }

    public function setIsCertified(bool $isCertified): self
    {
        $this->isCertified = $isCertified;
        return $this;
    }
}
