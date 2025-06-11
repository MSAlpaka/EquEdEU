<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

/**
 * Sprachenliste.
 * Language definitions.
 *
 * @author EEE
 * @version 1.0.0
 * @changed 2025-06-06
 *
 * @Extbase\ORM\Mapping\Entity
 */
class Language extends AbstractEntity implements DomainObjectInterface
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
     * @var string $languageIso // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=5)
     */
    protected string $languageIso;

    /**
     * @var string $labelEn // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $labelEn;

    /**
     * @var string $labelDe // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $labelDe;

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

    public function getLanguageIso(): string
    {
        return $this->languageIso;
    }

    public function setLanguageIso(string $languageIso): self
    {
        $this->languageIso = $languageIso;
        return $this;
    }

    public function getLabelEn(): string
    {
        return $this->labelEn;
    }

    public function setLabelEn(string $labelEn): self
    {
        $this->labelEn = $labelEn;
        return $this;
    }

    public function getLabelDe(): string
    {
        return $this->labelDe;
    }

    public function setLabelDe(string $labelDe): self
    {
        $this->labelDe = $labelDe;
        return $this;
    }
}
