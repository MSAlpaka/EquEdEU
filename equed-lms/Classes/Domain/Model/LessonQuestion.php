<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class LessonQuestion extends AbstractEntity
{
    /** Unique identifier */
    protected UuidInterface $uuid;

    /** Quiz this question belongs to */
    #[ManyToOne]
    #[Lazy]
    protected ?LessonQuiz $lessonQuiz = null;

    /** Question text */
    protected string $questionText = '';

    /** Type like "single" or "multiple" */
    protected string $questionType = 'single';

    /** Number of points for a correct answer */
    protected int $points = 1;

    /** Order within the quiz */
    protected int $orderNumber = 0;

    /** Creation timestamp */
    protected DateTimeImmutable $createdAt;

    /** Last update timestamp */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now            = new DateTimeImmutable();
        $this->uuid     = Uuid::uuid4();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getLessonQuiz(): ?LessonQuiz
    {
        return $this->lessonQuiz;
    }

    public function setLessonQuiz(?LessonQuiz $lessonQuiz): void
    {
        $this->lessonQuiz = $lessonQuiz;
    }

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): void
    {
        $this->questionText = $questionText;
    }

    public function getQuestionType(): string
    {
        return $this->questionType;
    }

    public function setQuestionType(string $questionType): void
    {
        $this->questionType = $questionType;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
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
