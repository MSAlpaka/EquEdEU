<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents an answer to a lesson attempt question.
 */
final class LessonAttemptAnswer extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?LessonAttempt $lessonAttempt = null;

    #[ManyToOne]
    #[Lazy]
    protected ?LessonAnswerOption $answerOption = null;

    protected string $customAnswer = '';

    protected bool $isCorrect = false;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * Gets the UUID of this answer record.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the associated lesson attempt.
     */
    public function getLessonAttempt(): ?LessonAttempt
    {
        return $this->lessonAttempt;
    }

    /**
     * Sets the associated lesson attempt.
     */
    public function setLessonAttempt(?LessonAttempt $lessonAttempt): void
    {
        $this->lessonAttempt = $lessonAttempt;
    }

    /**
     * Gets the selected answer option, if any.
     */
    public function getAnswerOption(): ?LessonAnswerOption
    {
        return $this->answerOption;
    }

    /**
     * Sets the selected answer option.
     */
    public function setAnswerOption(?LessonAnswerOption $answerOption): void
    {
        $this->answerOption = $answerOption;
    }

    /**
     * Gets any custom text answer.
     */
    public function getCustomAnswer(): string
    {
        return $this->customAnswer;
    }

    /**
     * Sets a custom text answer.
     */
    public function setCustomAnswer(string $customAnswer): void
    {
        $this->customAnswer = $customAnswer;
    }

    /**
     * Returns whether this answer was correct.
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * Marks this answer as correct or incorrect.
     */
    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
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
