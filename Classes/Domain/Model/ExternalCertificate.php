<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use Equed\EquedCore\Domain\Model\DocumentUpload;

/**
 * Externe Zertifikate der Nutzer.
 * External user certificates.
 *
 * @author EEE
 * @version 1.0.0
 * @changed 2025-06-06
 *
 * @Extbase\ORM\Mapping\Entity
 */
class ExternalCertificate extends AbstractEntity implements DomainObjectInterface
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
     * @var string $certificateNumber // Certifier
     * @Extbase\ORM\Mapping\Column(type="string", length=64)
     */
    protected string $certificateNumber;

    /**
     * @var string $issuedBy // Certifier
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $issuedBy;

    /**
     * @var int $issueDate // Certifier
     * @Extbase\ORM\Mapping\Column(type="integer")
     */
    protected int $issueDate;

    /**
     * @var DocumentUpload|null $relatedDocument
     */
    protected ?DocumentUpload $relatedDocument = null;

    /**
     * @var bool $isValid
     * @Extbase\ORM\Mapping\Column(type="boolean")
     */
    protected bool $isValid = false;

    public function onCertificationUpload(): void
    {
        // QMS-Hook: Verarbeitung bei externen Zertifikaten
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

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function setCertificateNumber(string $certificateNumber): self
    {
        $this->certificateNumber = $certificateNumber;
        return $this;
    }

    public function getIssuedBy(): string
    {
        return $this->issuedBy;
    }

    public function setIssuedBy(string $issuedBy): self
    {
        $this->issuedBy = $issuedBy;
        return $this;
    }

    public function getIssueDate(): int
    {
        return $this->issueDate;
    }

    public function setIssueDate(int $issueDate): self
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function getRelatedDocument(): ?DocumentUpload
    {
        return $this->relatedDocument;
    }

    public function setRelatedDocument(?DocumentUpload $relatedDocument): self
    {
        $this->relatedDocument = $relatedDocument;
        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
        return $this;
    }
}
