<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Module
 */
final class Module extends AbstractEntity
{
    protected string $uuid;

    protected string $title = '';

    /**
     * Translation key for the module title
     */
    protected ?string $titleKey = null;

    protected ?string $description = null;

    /**
     * Translation key for the description
     */
    protected ?string $descriptionKey = null;

    protected string $identifier = '';

    #[Extbase\ORM\ManyToOne]
    protected ?CourseProgram $courseProgram = null;

    /** @var ObjectStorage<Lesson> */
    #[Extbase\ORM\OneToMany(mappedBy: 'module', cascade: ['remove'])]
    protected ObjectStorage $lessons;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->lessons = new ObjectStorage();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    public function setTitleKey(?string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    public function setDescriptionKey(?string $descriptionKey): void
    {
        $this->descriptionKey = $descriptionKey;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    /**
     * @return ObjectStorage<Lesson>
     */
    public function getLessons(): ObjectStorage
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): void
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->attach($lesson);
        }
    }

    public function removeLesson(Lesson $lesson): void
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->detach($lesson);
        }
    }
}
