<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for system notifications.
 */
final class Notification extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $uuid;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    /**
     * @var FrontendUser|null
     */
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $recipient = null;

    /**
     * @var CourseInstance|null
     */
    #[ManyToOne]
    #[Lazy]
    protected ?CourseInstance $courseInstance = null;

    /**
     * @var Submission|null
     */
    #[ManyToOne]
    #[Lazy]
    protected ?Submission $submission = null;

    /**
     * @var UserCourseRecord|null
     */
    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    /**
     * @var string
     */
    protected string $type = 'system';

    /**
     * @var string
     */
    protected string $status = 'active';

    /**
     * @var bool
     */
    protected bool $isRead = false;

    /**
     * @var bool
     */
    protected bool $isArchived = false;

    /**
     * @var string
     */
    protected string $language = 'en';

    /**
     * @var string|null
     */
    protected ?string $titleKey = null;

    /**
     * @var string|null
     */
    protected ?string $customMessage = null;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
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
     * Returns the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return FrontendUser|null
     */
    public function getRecipient(): ?FrontendUser
    {
        return $this->recipient;
    }

    /**
     * @param FrontendUser|null $user
     */
    public function setRecipient(?FrontendUser $user): void
    {
        $this->recipient = $user;
    }

    /**
     * @return CourseInstance|null
     */
    public function getCourseInstance(): ?CourseInstance
    {
        return $this->courseInstance;
    }

    /**
     * @param CourseInstance|null $courseInstance
     */
    public function setCourseInstance(?CourseInstance $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    /**
     * @return Submission|null
     */
    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    /**
     * @param Submission|null $submission
     */
    public function setSubmission(?Submission $submission): void
    {
        $this->submission = $submission;
    }

    /**
     * @return UserCourseRecord|null
     */
    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * @param UserCourseRecord|null $record
     */
    public function setUserCourseRecord(?UserCourseRecord $record): void
    {
        $this->userCourseRecord = $record;
    }

    /**
     * Returns notification type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns notification status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Indicates if notification has been read.
     */
    public function isRead(): bool
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }

    /**
     * Indicates if notification is archived.
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    /**
     * Returns the language of the notification.
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    /**
     * @param string|null $titleKey
     */
    public function setTitleKey(?string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    /**
     * @return string|null
     */
    public function getCustomMessage(): ?string
    {
        return $this->customMessage;
    }

    /**
     * @param string|null $customMessage
     */
    public function setCustomMessage(?string $customMessage): void
    {
        $this->customMessage = $customMessage;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
