<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Domain\Model\LearningPath;
use Equed\EquedLms\Domain\Model\CourseProgram;

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

    #[Extbase\ORM\ManyToOne]
    #[Extbase\ORM\Lazy]
    protected ?CourseProgram $courseProgram = null;

    protected ?DateTimeImmutable $startDate = null;

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

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeImmutable $startDate): void
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
