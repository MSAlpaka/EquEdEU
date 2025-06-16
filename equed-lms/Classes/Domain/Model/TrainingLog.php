<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for training logs.
 */
final class TrainingLog extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;
    protected ?CourseInstance $courseInstance = null;
    protected ?FrontendUser $trainer = null;
    protected ?DateTimeImmutable $startTime = null;
    protected ?DateTimeImmutable $endTime = null;
    protected ?string $notes = null;
    #[Cascade('remove')]
    protected ?FileReference $attachment = null;
    protected bool $visibleToInstructor = false;
    protected bool $visibleToTrainee = false;
    protected bool $isArchived = false;
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
     * Gets the associated user course record.
    public function getUserCourseRecord(): ?UserCourseRecord
        return $this->userCourseRecord;
     * Sets the associated user course record.
     *
     * @param UserCourseRecord|null $userCourseRecord
    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
        $this->userCourseRecord = $userCourseRecord;
     * Gets the associated course instance.
    public function getCourseInstance(): ?CourseInstance
        return $this->courseInstance;
     * Sets the associated course instance.
     * @param CourseInstance|null $courseInstance
    public function setCourseInstance(?CourseInstance $courseInstance): void
        $this->courseInstance = $courseInstance;
     * Gets the trainer.
    public function getTrainer(): ?FrontendUser
        return $this->trainer;
     * Sets the trainer.
     * @param FrontendUser|null $trainer
    public function setTrainer(?FrontendUser $trainer): void
        $this->trainer = $trainer;
     * Gets the start time.
    public function getStartTime(): ?DateTimeImmutable
        return $this->startTime;
     * Sets the start time.
     * @param DateTimeImmutable|null $startTime
    public function setStartTime(?DateTimeImmutable $startTime): void
        $this->startTime = $startTime;
     * Gets the end time.
    public function getEndTime(): ?DateTimeImmutable
        return $this->endTime;
     * Sets the end time.
     * @param DateTimeImmutable|null $endTime
    public function setEndTime(?DateTimeImmutable $endTime): void
        $this->endTime = $endTime;
     * Gets notes.
    public function getNotes(): ?string
        return $this->notes;
     * Sets notes.
     * @param string|null $notes
    public function setNotes(?string $notes): void
        $this->notes = $notes;
     * Gets the attachment.
    public function getAttachment(): ?FileReference
        return $this->attachment;
     * Sets the attachment.
     * @param FileReference|null $attachment
    public function setAttachment(?FileReference $attachment): void
        $this->attachment = $attachment;
     * Checks visibility to instructor.
    public function isVisibleToInstructor(): bool
        return $this->visibleToInstructor;
     * Sets visibility to instructor.
     * @param bool $visibleToInstructor
    public function setVisibleToInstructor(bool $visibleToInstructor): void
        $this->visibleToInstructor = $visibleToInstructor;
     * Checks visibility to trainee.
    public function isVisibleToTrainee(): bool
        return $this->visibleToTrainee;
     * Sets visibility to trainee.
     * @param bool $visibleToTrainee
    public function setVisibleToTrainee(bool $visibleToTrainee): void
        $this->visibleToTrainee = $visibleToTrainee;
     * Checks if archived.
    public function isArchived(): bool
        return $this->isArchived;
     * Sets archived state.
     * @param bool $isArchived
    public function setIsArchived(bool $isArchived): void
        $this->isArchived = $isArchived;
     * Gets creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets creation timestamp.
     * @param DateTimeImmutable $createdAt
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets last update timestamp.
     * @param DateTimeImmutable $updatedAt
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
