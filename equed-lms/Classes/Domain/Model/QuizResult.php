<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for quiz results.
 */
final class QuizResult extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    #[ManyToOne]
    #[Lazy]
    protected ?LessonQuiz $lessonQuiz = null;

    protected int $score = 0;

    protected int $maxScore = 0;

    protected bool $passed = false;

    protected string $mode = 'web';

    protected DateTimeImmutable $submittedAt;

    protected string $lang = 'en';

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID, timestamps and submittedAt.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }

        $now = $this->clock->now();

        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }

        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }

        if (!isset($this->submittedAt)) {
            $this->submittedAt = $now;
        }
    }

    /**
     * Gets the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the user course record.
     */
    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Sets the user course record.
     *
     * @param UserCourseRecord|null $userCourseRecord
     */
    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    /**
     * Gets the lesson quiz.
     */
    public function getLessonQuiz(): ?LessonQuiz
    {
        return $this->lessonQuiz;
    }

    /**
     * Sets the lesson quiz.
     *
     * @param LessonQuiz|null $lessonQuiz
     */
    public function setLessonQuiz(?LessonQuiz $lessonQuiz): void
    {
        $this->lessonQuiz = $lessonQuiz;
    }

    /**
     * Gets the achieved score.
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Sets the achieved score.
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * Gets the maximum score.
     */
    public function getMaxScore(): int
    {
        return $this->maxScore;
    }

    /**
     * Sets the maximum score.
     */
    public function setMaxScore(int $maxScore): void
    {
        $this->maxScore = $maxScore;
    }

    /**
     * Checks if the quiz was passed.
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }

    /**
     * Marks the quiz as passed or not.
     */
    public function setPassed(bool $passed): void
    {
        $this->passed = $passed;
    }

    /**
     * Gets the mode of submission (e.g., web, app, demo, retry).
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Sets the mode of submission.
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Gets the submission timestamp.
     */
    public function getSubmittedAt(): DateTimeImmutable
    {
        return $this->submittedAt;
    }

    /**
     * Sets the submission timestamp.
     */
    public function setSubmittedAt(DateTimeImmutable $submittedAt): void
    {
        $this->submittedAt = $submittedAt;
    }

    /**
     * Gets the language code.
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * Sets the language code.
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Gets the creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
