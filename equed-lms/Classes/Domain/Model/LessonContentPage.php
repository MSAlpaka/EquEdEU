<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents a content page within a lesson.
 */
final class LessonContentPage extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?Lesson $lesson = null;

    protected string $title = '';

    protected ?string $titleKey = null;

    protected string $content = '';

    protected int $sorting = 0;

    #[ManyToOne]
    #[Lazy]
    protected ?FileReference $media = null;

    protected string $pageType = 'text'; // e.g. text, video, quiz

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * Gets the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the associated lesson.
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * Sets the associated lesson.
     */
    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * Gets the page title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the page title.
     */
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

    /**
     * Gets the page content (HTML or markdown).
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets the page content.
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Gets the sorting index.
     */
    public function getSorting(): int
    {
        return $this->sorting;
    }

    /**
     * Sets the sorting index.
     */
    public function setSorting(int $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * Gets the associated media file, if any.
     */
    public function getMedia(): ?FileReference
    {
        return $this->media;
    }

    /**
     * Sets the associated media file.
     */
    public function setMedia(?FileReference $media): void
    {
        $this->media = $media;
    }

    /**
     * Gets the page type.
     */
    public function getPageType(): string
    {
        return $this->pageType;
    }

    /**
     * Sets the page type.
     */
    public function setPageType(string $pageType): void
    {
        $this->pageType = $pageType;
    }

    /**
     * Gets creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
