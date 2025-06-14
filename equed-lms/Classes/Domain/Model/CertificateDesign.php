<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Inject;
use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;

/**
 * CertificateDesign
 *
 * Describes the visual design properties of generated certificates.
 */
final class CertificateDesign extends AbstractEntity
{
    use PersistenceTrait;

    /** Human readable name */
    protected string $name = '';

    /** Optional description */
    protected ?string $description = null;

    /** Template file reference */
    #[Lazy]
    protected ?FileReference $templateFile = null;

    /** Font family used for text */
    protected string $fontFamily = '';

    /** Background color in hex */
    protected string $backgroundColor = '';

    /** Text color in hex */
    protected string $textColor = '';

    /** Whether the design is active */
    protected bool $active = false;

    public function __construct()
    {
    }

    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTemplateFile(): ?FileReference
    {
        return $this->templateFile;
    }

    public function setTemplateFile(?FileReference $templateFile): void
    {
        $this->templateFile = $templateFile;
    }

    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }

    public function setFontFamily(string $fontFamily): void
    {
        $this->fontFamily = $fontFamily;
    }

    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function getTextColor(): string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): void
    {
        $this->textColor = $textColor;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
