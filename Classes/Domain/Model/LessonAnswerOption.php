<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents an answer option for a lesson question.
 */
final class LessonAnswerOption extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    protected ?LessonQuestion $question = null;

    protected string $text = '';

    protected bool $isCorrect = false;

    protected int $orderNumber = 0;

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

    public function getQuestion(): ?LessonQuestion
    {
        return $this->question;
    }

    public function setQuestion(?LessonQuestion $question): void
    {
        $this->question = $question;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }

    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
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
