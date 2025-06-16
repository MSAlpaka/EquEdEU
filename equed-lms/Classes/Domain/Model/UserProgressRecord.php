<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\ProgressRecordStatus;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for user progress records.
 */
final class UserProgressRecord extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $feUser = null;
    protected ?Lesson $lesson = null;
    protected ProgressRecordStatus $status = ProgressRecordStatus::Incomplete;
    protected ?string $statusKey = null;
    protected string $lessonPage = '';
    protected bool $completed = false;
    protected ?DateTimeImmutable $completedAt = null;
    protected int $progressPercent = 0;
    protected ?DateTimeImmutable $lastAccessedAt = null;
    protected int $attemptCount = 0;
    protected int $timeSpentSeconds = 0;
    protected bool $feedbackSubmitted = false;
    protected ?string $notes = null;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the frontend user.
    public function getFeUser(): ?FrontendUser
        return $this->feUser;
     * Sets the frontend user.
     *
     * @param FrontendUser|null $feUser
    public function setFeUser(?FrontendUser $feUser): void
        $this->feUser = $feUser;
     * Gets the lesson.
    public function getLesson(): ?Lesson
        return $this->lesson;
     * Sets the lesson.
     * @param Lesson|null $lesson
    public function setLesson(?Lesson $lesson): void
        $this->lesson = $lesson;
     * Gets the progress status.
    public function getStatus(): ProgressRecordStatus
        return $this->status;
     * Sets the progress status.
    public function setStatus(ProgressRecordStatus|string $status): void
        if (is_string($status)) {
            $status = ProgressRecordStatus::from($status);
        $this->status = $status;
     * Gets the translation key for status.
    public function getStatusKey(): ?string
        return $this->statusKey;
     * Sets the translation key for status.
     * @param string|null $statusKey
    public function setStatusKey(?string $statusKey): void
        $this->statusKey = $statusKey;
    public function getLessonPage(): string
        return $this->lessonPage;
    public function setLessonPage(string $lessonPage): void
        $this->lessonPage = $lessonPage;
    public function isCompleted(): bool
        return $this->completed;
    public function setCompleted(bool $completed): void
        $this->completed = $completed;
    public function getCompletedAt(): ?DateTimeImmutable
        return $this->completedAt;
    public function setCompletedAt(?DateTimeImmutable $completedAt): void
        $this->completedAt = $completedAt;
    public function getProgressPercent(): int
        return $this->progressPercent;
    public function setProgressPercent(int $progressPercent): void
        $this->progressPercent = $progressPercent;
    public function getLastAccessedAt(): ?DateTimeImmutable
        return $this->lastAccessedAt;
    public function setLastAccessedAt(?DateTimeImmutable $lastAccessedAt): void
        $this->lastAccessedAt = $lastAccessedAt;
    public function getAttemptCount(): int
        return $this->attemptCount;
    public function setAttemptCount(int $attemptCount): void
        $this->attemptCount = $attemptCount;
    public function getTimeSpentSeconds(): int
        return $this->timeSpentSeconds;
    public function setTimeSpentSeconds(int $timeSpentSeconds): void
        $this->timeSpentSeconds = $timeSpentSeconds;
    public function isFeedbackSubmitted(): bool
        return $this->feedbackSubmitted;
    public function setFeedbackSubmitted(bool $feedbackSubmitted): void
        $this->feedbackSubmitted = $feedbackSubmitted;
    public function getNotes(): ?string
        return $this->notes;
    public function setNotes(?string $notes): void
        $this->notes = $notes;
     * Gets the creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets the creation timestamp.
     * @param DateTimeImmutable $createdAt
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets the last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets the last update timestamp.
     * @param DateTimeImmutable $updatedAt
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
