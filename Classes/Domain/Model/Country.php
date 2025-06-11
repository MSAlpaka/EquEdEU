<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

/**
 * Stammdaten zu Ländern.
 * Basic country information.
 *
 * @author EEE
 * @version 1.0.0
 * @changed 2025-06-06
 *
 * @Extbase\ORM\Mapping\Entity
 */
class Country extends AbstractEntity implements DomainObjectInterface
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
     * @var string $countryIso // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=2)
     */
    protected string $countryIso;

    /**
     * @var string $nameEn // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $nameEn;

    /**
     * @var string $nameDe // ServiceCenter
     * @Extbase\ORM\Mapping\Column(type="string", length=255)
     */
    protected string $nameDe;

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

    public function getCountryIso(): string
    {
        return $this->countryIso;
    }

    public function setCountryIso(string $countryIso): self
    {
        $this->countryIso = $countryIso;
        return $this;
    }

    public function getNameEn(): string
    {
        return $this->nameEn;
    }

    public function setNameEn(string $nameEn): self
    {
        $this->nameEn = $nameEn;
        return $this;
    }

    public function getNameDe(): string
    {
        return $this->nameDe;
    }

    public function setNameDe(string $nameDe): self
    {
        $this->nameDe = $nameDe;
        return $this;
    }
}
