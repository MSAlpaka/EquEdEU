<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;
use Equed\EquedLms\Enum\SubmissionStatus;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for user submissions.
 */
final class UserSubmission extends AbstractEntity
{
    use PersistenceTrait;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    #[ManyToOne]
    #[Lazy]
    protected ?Lesson $lesson = null;

    #[ManyToOne]
    #[Lazy]
    protected ?PracticeTest $practiceTest = null;

    protected string $submissionType = 'upload';

    protected string $title = '';

    #[Cascade('remove')]
    protected ?FileReference $file = null;

    protected SubmissionStatus $status = SubmissionStatus::Pending;
    protected ?string $statusKey = null;

    protected ?string $instructorComment = null;

    #[Cascade('remove')]
    #[Lazy]
    protected ?FileReference $instructorFeedbackFile = null;

    protected ?float $score = null;

    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
    }


    /**
     * Gets the related UserCourseRecord.
     */
    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Sets the related UserCourseRecord.
     *
     * @param UserCourseRecord|null $userCourseRecord
     */
    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    /**
     * Gets the related lesson.
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * Sets the related lesson.
     *
     * @param Lesson|null $lesson
     */
    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * Gets the related practice test.
     */
    public function getPracticeTest(): ?PracticeTest
    {
        return $this->practiceTest;
    }

    /**
     * Sets the related practice test.
     *
     * @param PracticeTest|null $practiceTest
     */
    public function setPracticeTest(?PracticeTest $practiceTest): void
    {
        $this->practiceTest = $practiceTest;
    }

    /**
     * Gets the submission type.
     */
    public function getSubmissionType(): string
    {
        return $this->submissionType;
    }

    /**
     * Sets the submission type.
     *
     * @param string $submissionType
     */
    public function setSubmissionType(string $submissionType): void
    {
        $this->submissionType = $submissionType;
    }

    /**
     * Gets the title.
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
     * Gets the uploaded file reference.
     */
    public function getFile(): ?FileReference
    {
        return $this->file;
    }

    /**
     * Sets the uploaded file reference.
     *
     * @param FileReference|null $file
     */
    public function setFile(?FileReference $file): void
    {
        $this->file = $file;
    }

    /**
     * Gets the submission status.
     */
    public function getStatus(): SubmissionStatus
    {
        return $this->status;
    }

    /**
     * Sets the submission status.
     *
     * @param SubmissionStatus|string $status
     */
    public function setStatus(SubmissionStatus|string $status): void
    {
        if (is_string($status)) {
            $status = SubmissionStatus::from($status);
        }
        $this->status = $status;
    }

    /**
     * Gets the translation key for status.
     */
    public function getStatusKey(): ?string
    {
        return $this->statusKey;
    }

    /**
     * Sets the translation key for status.
     *
     * @param string|null $statusKey
     */
    public function setStatusKey(?string $statusKey): void
    {
        $this->statusKey = $statusKey;
    }

    /**
     * Gets the instructor's comment.
     */
    public function getInstructorComment(): ?string
    {
        return $this->instructorComment;
    }

    /**
     * Sets the instructor's comment.
     *
     * @param string|null $instructorComment
     */
    public function setInstructorComment(?string $instructorComment): void
    {
        $this->instructorComment = $instructorComment;
    }

    /**
     * Gets the instructor feedback file reference.
     */
    public function getInstructorFeedbackFile(): ?FileReference
    {
        return $this->instructorFeedbackFile;
    }

    /**
     * Sets the instructor feedback file reference.
     *
     * @param FileReference|null $instructorFeedbackFile
     */
    public function setInstructorFeedbackFile(?FileReference $instructorFeedbackFile): void
    {
        $this->instructorFeedbackFile = $instructorFeedbackFile;
    }

    /**
     * Gets the optional score.
     */
    public function getScore(): ?float
    {
        return $this->score;
    }

    /**
     * Sets the optional score.
     *
     * @param float|null $score
     */
    public function setScore(?float $score): void
    {
        $this->score = $score;
    }

}
