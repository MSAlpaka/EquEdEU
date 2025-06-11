<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * LearningPath
 *
 * Bundles multiple Courses into a structured program.
 */
final class LearningPath extends AbstractEntity
{
    protected string $title = '';

    protected string $description = '';

    protected int $level = 0;

    /**
     * @var ObjectStorage<Course>
     */
    protected ObjectStorage $courses;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ObjectStorage();
    }

    /**
     * Get the title of the learning path.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the title of the learning path.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the description of the learning path.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the description of the learning path.
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the EQF level of the learning path.
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Set the EQF level of the learning path.
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * Get all courses in this learning path.
     *
     * @return ObjectStorage<Course>
     */
    public function getCourses(): ObjectStorage
    {
        return $this->courses;
    }

    /**
     * Add a course to this learning path.
     */
    public function addCourse(Course $course): void
    {
        if (!$this->courses->contains($course)) {
            $this->courses->attach($course);
        }
    }

    /**
     * Remove a course from this learning path.
     */
    public function removeCourse(Course $course): void
    {
        if ($this->courses->contains($course)) {
            $this->courses->detach($course);
        }
    }
}
