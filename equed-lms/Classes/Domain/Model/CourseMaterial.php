<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use Equed\Core\Service\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * CourseMaterial
 *
 * Represents materials (PDFs, videos, worksheets, links) associated with lessons.
 */
final class CourseMaterial extends AbstractEntity
{
    #[Inject]
    protected ClockInterface $clock;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    protected string $uuid;

    protected string $title = '';

    protected string $type = 'pdf';

    protected bool $required = false;

    protected bool $downloadOnly = false;

    #[ManyToOne]
    protected ?Lesson $lesson = null;

    #[Lazy]
    protected ?FileReference $file = null;

    #[Lazy]
    protected ?FrontendUser $uploadedBy = null;

    protected string $lang = 'en';

    protected string $requiredDocuLevel = 'none';

    protected bool $isMandatoryForCompletion = false;

    protected bool $isBadgeRelevant = false;

    protected bool $accessLogged = false;

    protected string $linkedToLevel = '';

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }
        $now = $this->clock->now();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    public function isDownloadOnly(): bool
    {
        return $this->downloadOnly;
    }

    public function setDownloadOnly(bool $downloadOnly): void
    {
        $this->downloadOnly = $downloadOnly;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function getFile(): ?FileReference
    {
        return $this->file;
    }

    public function setFile(?FileReference $file): void
    {
        $this->file = $file;
    }

    public function getUploadedBy(): ?FrontendUser
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?FrontendUser $uploadedBy): void
    {
        $this->uploadedBy = $uploadedBy;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function getRequiredDocuLevel(): string
    {
        return $this->requiredDocuLevel;
    }

    public function setRequiredDocuLevel(string $requiredDocuLevel): void
    {
        $this->requiredDocuLevel = $requiredDocuLevel;
    }

    public function isMandatoryForCompletion(): bool
    {
        return $this->isMandatoryForCompletion;
    }

    public function setIsMandatoryForCompletion(bool $isMandatoryForCompletion): void
    {
        $this->isMandatoryForCompletion = $isMandatoryForCompletion;
    }

    public function isBadgeRelevant(): bool
    {
        return $this->isBadgeRelevant;
    }

    public function setIsBadgeRelevant(bool $isBadgeRelevant): void
    {
        $this->isBadgeRelevant = $isBadgeRelevant;
    }

    public function isAccessLogged(): bool
    {
        return $this->accessLogged;
    }

    public function setAccessLogged(bool $accessLogged): void
    {
        $this->accessLogged = $accessLogged;
    }

    public function getLinkedToLevel(): string
    {
        return $this->linkedToLevel;
    }

    public function setLinkedToLevel(string $linkedToLevel): void
    {
        $this->linkedToLevel = $linkedToLevel;
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
