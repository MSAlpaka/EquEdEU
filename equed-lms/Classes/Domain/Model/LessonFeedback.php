<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents feedback given by a user on a lesson.
 */
final class LessonFeedback extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    protected int $contentRating = 0;
    protected int $instructorRating = 0;
    protected int $locationRating = 0;
    protected bool $standardCheck = false;
    protected bool $wantsNextInfo = false;
    protected ?string $courseWish = null;
    protected ?string $textFeedback = null;
    protected bool $releaseToInstructor = false;
    protected string $lang = 'en';

    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
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

    public function getContentRating(): int
    {
        return $this->contentRating;
    }

    public function setContentRating(int $contentRating): void
    {
        $this->contentRating = $contentRating;
    }

    public function getInstructorRating(): int
    {
        return $this->instructorRating;
    }

    public function setInstructorRating(int $instructorRating): void
    {
        $this->instructorRating = $instructorRating;
    }

    public function getLocationRating(): int
    {
        return $this->locationRating;
    }

    public function setLocationRating(int $locationRating): void
    {
        $this->locationRating = $locationRating;
    }

    public function isStandardCheck(): bool
    {
        return $this->standardCheck;
    }

    public function setStandardCheck(bool $standardCheck): void
    {
        $this->standardCheck = $standardCheck;
    }

    public function isWantsNextInfo(): bool
    {
        return $this->wantsNextInfo;
    }

    public function setWantsNextInfo(bool $wantsNextInfo): void
    {
        $this->wantsNextInfo = $wantsNextInfo;
    }

    public function getCourseWish(): ?string
    {
        return $this->courseWish;
    }

    public function setCourseWish(?string $courseWish): void
    {
        $this->courseWish = $courseWish;
    }

    public function getTextFeedback(): ?string
    {
        return $this->textFeedback;
    }

    public function setTextFeedback(?string $textFeedback): void
    {
        $this->textFeedback = $textFeedback;
    }

    public function isReleaseToInstructor(): bool
    {
        return $this->releaseToInstructor;
    }

    public function setReleaseToInstructor(bool $releaseToInstructor): void
    {
        $this->releaseToInstructor = $releaseToInstructor;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
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
