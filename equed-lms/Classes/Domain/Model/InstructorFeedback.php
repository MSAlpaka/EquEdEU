<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\LanguageCode;

/**
 * InstructorFeedback
 *
 * Represents feedback provided by an instructor on a submission or user course record.
 */
final class InstructorFeedback extends AbstractEntity
{
    protected UuidInterface $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    #[ManyToOne]
    #[Lazy]
    protected ?Submission $submission = null;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $instructor = null;

    protected string $comment = '';

    protected int $rating = 0;

    protected string $status = 'submitted';

    protected bool $visibleToParticipant = false;

    protected bool $visibleToTrainingCenter = true;

    protected bool $visibleToCertifier = true;

    protected bool $isArchived = false;

    protected LanguageCode $language = LanguageCode::EN;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $reviewedBy = null;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    public function setUserCourseRecord(?UserCourseRecord $record): void
    {
        $this->userCourseRecord = $record;
    }

    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    public function setSubmission(?Submission $submission): void
    {
        $this->submission = $submission;
    }

    public function getInstructor(): ?FrontendUser
    {
        return $this->instructor;
    }

    public function setInstructor(?FrontendUser $instructor): void
    {
        $this->instructor = $instructor;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function isVisibleToParticipant(): bool
    {
        return $this->visibleToParticipant;
    }

    public function setVisibleToParticipant(bool $visible): void
    {
        $this->visibleToParticipant = $visible;
    }

    public function isVisibleToTrainingCenter(): bool
    {
        return $this->visibleToTrainingCenter;
    }

    public function setVisibleToTrainingCenter(bool $visible): void
    {
        $this->visibleToTrainingCenter = $visible;
    }

    public function isVisibleToCertifier(): bool
    {
        return $this->visibleToCertifier;
    }

    public function setVisibleToCertifier(bool $visible): void
    {
        $this->visibleToCertifier = $visible;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $archived): void
    {
        $this->isArchived = $archived;
    }

    public function getLanguage(): LanguageCode
    {
        return $this->language;
    }

    public function setLanguage(LanguageCode $language): void
    {
        $this->language = $language;
    }

    public function getReviewedBy(): ?FrontendUser
    {
        return $this->reviewedBy;
    }

    public function setReviewedBy(?FrontendUser $user): void
    {
        $this->reviewedBy = $user;
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
