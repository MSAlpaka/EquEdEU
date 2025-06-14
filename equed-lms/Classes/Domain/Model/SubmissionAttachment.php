<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for submission attachments.
 */
final class SubmissionAttachment extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[ManyToOne]
    #[Lazy]
    protected ?UserSubmission $userSubmission = null;

    #[ManyToOne]
    #[Cascade('remove')]
    protected ?FileReference $file = null;

    protected string $title = '';

    protected string $type = 'fallbericht';

    protected string $visibility = 'instructor_only';

    protected string $status = 'active';

    protected LanguageCode $lang = LanguageCode::EN;

    protected bool $isActive = true;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }
        if (!isset($this->createdAt)) {
            $now = $this->clock->now();
            $this->createdAt = $now;
            $this->updatedAt = $now;
        }
    }

    /**
     * Gets the UUID.
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the associated user submission.
     *
     * @return UserSubmission|null
     */
    public function getUserSubmission(): ?UserSubmission
    {
        return $this->userSubmission;
    }

    /**
     * Sets the associated user submission.
     *
     * @param UserSubmission|null $userSubmission
     */
    public function setUserSubmission(?UserSubmission $userSubmission): void
    {
        $this->userSubmission = $userSubmission;
    }

    /**
     * Gets the file reference.
     *
     * @return FileReference|null
     */
    public function getFile(): ?FileReference
    {
        return $this->file;
    }

    /**
     * Sets the file reference.
     *
     * @param FileReference|null $file
     */
    public function setFile(?FileReference $file): void
    {
        $this->file = $file;
    }

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the type of attachment.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type of attachment.
     *
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets the visibility.
     *
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * Sets the visibility.
     *
     * @param string $visibility
     */
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * Gets the status of the attachment.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets the status of the attachment.
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets the language code.
     *
     * @return string
     */
    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    /**
     * Sets the language code.
     *
     * @param LanguageCode $lang
     */
    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Checks if the attachment is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Sets the active state.
     *
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * Gets the creation timestamp.
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation timestamp.
     *
     * @param DateTimeImmutable $createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update timestamp.
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update timestamp.
     *
     * @param DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
