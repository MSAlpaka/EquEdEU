<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents an attempt at answering lesson questions by a user.
 */
final class LessonAttempt extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?LessonQuestion $question = null;

    protected int $feUser = 0;

    protected string $answer = '';

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
     * Returns the UUID of this attempt.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the related question.
     */
    public function getQuestion(): ?LessonQuestion
    {
        return $this->question;
    }

    /**
     * Sets the related question.
     */
    public function setQuestion(?LessonQuestion $question): void
    {
        $this->question = $question;
    }

    /**
     * Gets the frontend user ID who made the attempt.
     */
    public function getFeUser(): int
    {
        return $this->feUser;
    }

    /**
     * Sets the frontend user ID who made the attempt.
     */
    public function setFeUser(int $feUser): void
    {
        $this->feUser = $feUser;
    }

    /**
     * Gets the answer provided.
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * Sets the answer provided.
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * Returns whether the answer was correct.
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * Marks the attempt as correct or incorrect.
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
     * Gets the last updated timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last updated timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
