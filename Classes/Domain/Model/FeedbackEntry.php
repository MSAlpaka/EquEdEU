<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * FeedbackEntry
 *
 * Represents a single feedback question/answer pair within a course feedback.
 */
final class FeedbackEntry extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?CourseFeedback $courseFeedback = null;

    protected string $questionKey = ''; // LLL:EXT:equed_lms/Resources/Private/Language/locallang.xlf:feedback.question.organization

    protected string $answerType = 'scale'; // scale | text | bool

    protected ?string $answerText = null;

    protected ?int $answerScale = null;

    protected ?bool $answerBool = null;

    protected bool $isRequired = false;

    protected string $language = 'en';

    protected bool $isArchived = false;

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

    public function getCourseFeedback(): ?CourseFeedback
    {
        return $this->courseFeedback;
    }

    public function setCourseFeedback(?CourseFeedback $courseFeedback): void
    {
        $this->courseFeedback = $courseFeedback;
    }

    public function getQuestionKey(): string
    {
        return $this->questionKey;
    }

    public function setQuestionKey(string $questionKey): void
    {
        $this->questionKey = $questionKey;
    }

    public function getAnswerType(): string
    {
        return $this->answerType;
    }

    public function setAnswerType(string $answerType): void
    {
        $this->answerType = $answerType;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(?string $answerText): void
    {
        $this->answerText = $answerText;
    }

    public function getAnswerScale(): ?int
    {
        return $this->answerScale;
    }

    public function setAnswerScale(?int $answerScale): void
    {
        $this->answerScale = $answerScale;
    }

    public function getAnswerBool(): ?bool
    {
        return $this->answerBool;
    }

    public function setAnswerBool(?bool $answerBool): void
    {
        $this->answerBool = $answerBool;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
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
