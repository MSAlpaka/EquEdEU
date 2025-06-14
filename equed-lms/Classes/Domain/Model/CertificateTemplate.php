<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Enum\BadgeLevel;
use Equed\EquedLms\Enum\CertificateDesignType;
use Equed\EquedLms\Enum\LanguageCode;

/**
 * CertificateTemplate
 *
 * Defines a certificate template with design, language, and associated program.
 */
final class CertificateTemplate extends AbstractEntity
{
    use PersistenceTrait;

    /**
     * Human readable title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * Optional translation key for title
     */
    protected ?string $titleKey = null;

    /**
     * Optional description text
     */
    protected ?string $description = null;

    /**
     * Linked course program
     */
    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;

    /**
     * Language ISO code
     *
     * @var LanguageCode
     */
    protected LanguageCode $language = LanguageCode::EN;

    /**
     * Required badge level to use this template
     */
    protected BadgeLevel $badgeLevel = BadgeLevel::None;

    /**
     * Visual design type
     */
    protected CertificateDesignType $designType = CertificateDesignType::Classic;

    /**
     * Flag if template can be chosen publicly
     */
    protected bool $isPublic = true;

    /**
     * Background image file
     */
    #[Cascade('remove')]
    #[Lazy]
    protected ?FileReference $backgroundFile = null;

    /**
     * Whether template is archived
     */
    protected bool $isArchived = false;

    /**
     * Creation timestamp
     */
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    public function setTitleKey(?string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function getLanguage(): LanguageCode
    {
        return $this->language;
    }

    public function setLanguage(LanguageCode $language): void
    {
        $this->language = $language;
    }

    public function getBadgeLevel(): BadgeLevel
    {
        return $this->badgeLevel;
    }

    public function setBadgeLevel(BadgeLevel $badgeLevel): void
    {
        $this->badgeLevel = $badgeLevel;
    }

    public function getDesignType(): CertificateDesignType
    {
        return $this->designType;
    }

    public function setDesignType(CertificateDesignType $designType): void
    {
        $this->designType = $designType;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    public function getBackgroundFile(): ?FileReference
    {
        return $this->backgroundFile;
    }

    public function setBackgroundFile(?FileReference $backgroundFile): void
    {
        $this->backgroundFile = $backgroundFile;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
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
