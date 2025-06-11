<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Domain\Model\LearningPath;

/**
 * Course
 *
 * Basic course record.
 */
final class Course extends AbstractEntity
{
    #[Extbase\ORM\ManyToOne]
    #[Extbase\ORM\Lazy]
    protected ?LearningPath $learningPath = null;

    protected string $title = '';

    protected string $description = '';

    protected int $courseProgram = 0;

    protected int $startDate = 0;

    protected string $location = '';

    public function getLearningPath(): ?LearningPath
    {
        return $this->learningPath;
    }

    public function setLearningPath(?LearningPath $learningPath): void
    {
        $this->learningPath = $learningPath;
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

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function setStartDate(int $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }
}
