<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * ExamResult
 *
 * Represents the aggregated result for a user's course record exam.
 */
final class ExamResult extends AbstractEntity
{
    /**
     * Unique identifier for this result
     *
     * @var UuidInterface
     */
    protected UuidInterface $uuid;

    #[ManyToOne]
    #[Lazy]
    /** @var UserCourseRecord|null */
    protected ?UserCourseRecord $userCourseRecord = null;

    /**
     * Whether the theory portion was passed
     *
     * @var bool
     */
    protected bool $theoryPassed = false;

    /**
     * Whether the practice portion was passed
     *
     * @var bool
     */
    protected bool $practicePassed = false;

    /**
     * Whether the case study portion was passed
     *
     * @var bool
     */
    protected bool $casePassed = false;

    /**
     * Overall score percentage
     *
     * @var float
     */
    protected float $totalScore = 0.0;

    /**
     * Flag if the overall exam was passed
     *
     * @var bool
     */
    protected bool $overallPassed = false;

    /**
     * Optional comment regarding the overall result
     *
     * @var string|null
     */
    protected ?string $overallComment = null;

    /**
     * If set the result is archived
     *
     * @var bool
     */
    protected bool $isArchived = false;

    /**
     * Creation timestamp
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     *
     * @var DateTimeImmutable
     */
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

    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    public function isTheoryPassed(): bool
    {
        return $this->theoryPassed;
    }

    public function setTheoryPassed(bool $theoryPassed): void
    {
        $this->theoryPassed = $theoryPassed;
    }

    public function isPracticePassed(): bool
    {
        return $this->practicePassed;
    }

    public function setPracticePassed(bool $practicePassed): void
    {
        $this->practicePassed = $practicePassed;
    }

    public function isCasePassed(): bool
    {
        return $this->casePassed;
    }

    public function setCasePassed(bool $casePassed): void
    {
        $this->casePassed = $casePassed;
    }

    public function getTotalScore(): float
    {
        return $this->totalScore;
    }

    public function setTotalScore(float $totalScore): void
    {
        $this->totalScore = $totalScore;
    }

    public function isOverallPassed(): bool
    {
        return $this->overallPassed;
    }

    public function setOverallPassed(bool $overallPassed): void
    {
        $this->overallPassed = $overallPassed;
    }

    public function getOverallComment(): ?string
    {
        return $this->overallComment;
    }

    public function setOverallComment(?string $overallComment): void
    {
        $this->overallComment = $overallComment;
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
