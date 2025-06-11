<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * CourseGoal
 *
 * Represents a goal within a course or lesson.
 */
final class CourseGoal extends AbstractEntity
{
    #[Inject]
    protected ClockInterface $clock;

    protected string $title = '';

    protected string $description = '';

    protected int $courseProgram = 0;

    protected int $lesson = 0;

    protected bool $isCoreGoal = false;

    protected bool $isVisibleToUser = false;

    protected int $goalType = 0;

    protected string $category = '';

    protected int $requirementLevel = 0;

    protected bool $requiredForCertification = false;

    protected bool $requiredForCourseAccess = false;

    protected bool $isExamRelevant = false;

    protected string $weighting = '';

    protected string $position = '';

    protected string $notes = '';

    protected string $language = '';

    protected string $uuid = '';

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function initializeObject(): void
    {
        $now = $this->clock->now();

        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }

        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCourseProgram(): int
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(int $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function getLesson(): int
    {
        return $this->lesson;
    }

    public function setLesson(int $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function isCoreGoal(): bool
    {
        return $this->isCoreGoal;
    }

    public function setIsCoreGoal(bool $isCoreGoal): void
    {
        $this->isCoreGoal = $isCoreGoal;
    }

    public function isVisibleToUser(): bool
    {
        return $this->isVisibleToUser;
    }

    public function setIsVisibleToUser(bool $isVisibleToUser): void
    {
        $this->isVisibleToUser = $isVisibleToUser;
    }

    public function getGoalType(): int
    {
        return $this->goalType;
    }

    public function setGoalType(int $goalType): void
    {
        $this->goalType = $goalType;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getRequirementLevel(): int
    {
        return $this->requirementLevel;
    }

    public function setRequirementLevel(int $requirementLevel): void
    {
        $this->requirementLevel = $requirementLevel;
    }

    public function isRequiredForCertification(): bool
    {
        return $this->requiredForCertification;
    }

    public function setRequiredForCertification(bool $requiredForCertification): void
    {
        $this->requiredForCertification = $requiredForCertification;
    }

    public function isRequiredForCourseAccess(): bool
    {
        return $this->requiredForCourseAccess;
    }

    public function setRequiredForCourseAccess(bool $requiredForCourseAccess): void
    {
        $this->requiredForCourseAccess = $requiredForCourseAccess;
    }

    public function isExamRelevant(): bool
    {
        return $this->isExamRelevant;
    }

    public function setIsExamRelevant(bool $isExamRelevant): void
    {
        $this->isExamRelevant = $isExamRelevant;
    }

    public function getWeighting(): string
    {
        return $this->weighting;
    }

    public function setWeighting(string $weighting): void
    {
        $this->weighting = $weighting;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
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
