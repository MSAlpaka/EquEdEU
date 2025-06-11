<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\ExamTemplate;

/**
 * ExamAttempt
 *
 * Represents a user's attempt at an exam template.
 */
final class ExamAttempt extends AbstractEntity
{
    protected UuidInterface $uuid;

    #[ManyToOne]
    protected FrontendUser $frontendUser;

    #[ManyToOne]
    protected ExamTemplate $examTemplate;

    protected float $resultPercentage = 0.0;

    protected bool $passed = false;

    protected string $attemptData = '';

    protected DateTimeImmutable $attemptedAt;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4();
        $this->attemptedAt = $now;
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getFrontendUser(): FrontendUser
    {
        return $this->frontendUser;
    }

    public function setFrontendUser(FrontendUser $frontendUser): void
    {
        $this->frontendUser = $frontendUser;
    }

    public function getExamTemplate(): ExamTemplate
    {
        return $this->examTemplate;
    }

    public function setExamTemplate(ExamTemplate $examTemplate): void
    {
        $this->examTemplate = $examTemplate;
    }

    public function getResultPercentage(): float
    {
        return $this->resultPercentage;
    }

    public function setResultPercentage(float $resultPercentage): void
    {
        $this->resultPercentage = $resultPercentage;
    }

    public function isPassed(): bool
    {
        return $this->passed;
    }

    public function setPassed(bool $passed): void
    {
        $this->passed = $passed;
    }

    public function getAttemptData(): string
    {
        return $this->attemptData;
    }

    public function setAttemptData(string $attemptData): void
    {
        $this->attemptData = $attemptData;
    }

    public function getAttemptedAt(): DateTimeImmutable
    {
        return $this->attemptedAt;
    }

    public function setAttemptedAt(DateTimeImmutable $attemptedAt): void
    {
        $this->attemptedAt = $attemptedAt;
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
