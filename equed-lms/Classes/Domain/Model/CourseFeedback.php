<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\LanguageCode;

final class CourseFeedback extends AbstractEntity
{
    /** Unique identifier */
    protected UuidInterface $uuid;

    /** Related user course record */
    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    /** User who submitted the feedback */
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $submittedByUser = null;

    /** Rating for the instructor */
    protected int $ratingInstructor = 0;

    /** Rating for the training location */
    protected int $ratingTrainingLocation = 0;

    /** Overall course rating */
    protected int $ratingOverall = 0;

    /** Indicates if the course covered the standard */
    protected bool $standardCoverageConfirmed = false;

    /** Whether the user wants follow up information */
    protected bool $wantsFollowupInfo = false;

    /** Show feedback to instructor */
    protected bool $isVisibleToInstructor = false;

    /** Show feedback to training center */
    protected bool $isVisibleToTrainingCenter = false;

    /** Language of free text fields */
    protected LanguageCode $language = LanguageCode::EN;

    /** Optional wishes for future courses */
    protected ?string $courseWishes = null;

    /** Optional free text comment */
    protected ?string $comment = null;

    /** Submission status */
    protected string $status = 'submitted';

    /** Creation timestamp */
    protected DateTimeImmutable $createdAt;

    /** Last update timestamp */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $now = new DateTimeImmutable();
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

    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    public function getSubmittedByUser(): ?FrontendUser
    {
        return $this->submittedByUser;
    }

    public function setSubmittedByUser(?FrontendUser $submittedByUser): void
    {
        $this->submittedByUser = $submittedByUser;
    }

    public function getRatingInstructor(): int
    {
        return $this->ratingInstructor;
    }

    public function setRatingInstructor(int $ratingInstructor): void
    {
        $this->ratingInstructor = $ratingInstructor;
    }

    public function getRatingTrainingLocation(): int
    {
        return $this->ratingTrainingLocation;
    }

    public function setRatingTrainingLocation(int $ratingTrainingLocation): void
    {
        $this->ratingTrainingLocation = $ratingTrainingLocation;
    }

    public function getRatingOverall(): int
    {
        return $this->ratingOverall;
    }

    public function setRatingOverall(int $ratingOverall): void
    {
        $this->ratingOverall = $ratingOverall;
    }

    public function isStandardCoverageConfirmed(): bool
    {
        return $this->standardCoverageConfirmed;
    }

    public function setStandardCoverageConfirmed(bool $confirmed): void
    {
        $this->standardCoverageConfirmed = $confirmed;
    }

    public function isWantsFollowupInfo(): bool
    {
        return $this->wantsFollowupInfo;
    }

    public function setWantsFollowupInfo(bool $wants): void
    {
        $this->wantsFollowupInfo = $wants;
    }

    public function isVisibleToInstructor(): bool
    {
        return $this->isVisibleToInstructor;
    }

    public function setIsVisibleToInstructor(bool $visible): void
    {
        $this->isVisibleToInstructor = $visible;
    }

    public function isVisibleToTrainingCenter(): bool
    {
        return $this->isVisibleToTrainingCenter;
    }

    public function setIsVisibleToTrainingCenter(bool $visible): void
    {
        $this->isVisibleToTrainingCenter = $visible;
    }

    public function getLanguage(): LanguageCode
    {
        return $this->language;
    }

    public function setLanguage(LanguageCode $language): void
    {
        $this->language = $language;
    }

    public function getCourseWishes(): ?string
    {
        return $this->courseWishes;
    }

    public function setCourseWishes(?string $courseWishes): void
    {
        $this->courseWishes = $courseWishes;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
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
