<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\Module;

/**
 * Lesson
 *
 * Represents a lesson with content pages, quiz questions, materials, and progress settings.
 */
final class Lesson extends AbstractEntity
{
    protected string $uuid;

    protected string $title = '';

    protected ?string $titleKey = null;

    protected ?string $introduction = null;

    protected int $expectedDuration = 0;

    protected string $category = '';

    protected bool $visible = true;

    #[Extbase\ORM\ManyToOne]
    protected ?Module $module = null;

    /**
     * @var ObjectStorage<LessonContentPage>
     */
    #[Extbase\ORM\OneToMany(mappedBy: 'lesson', cascade: ['remove'])]
    protected ObjectStorage $pages;

    /**
     * @var ObjectStorage<LessonQuestion>
     */
    #[Extbase\ORM\OneToMany(mappedBy: 'lesson', cascade: ['remove'])]
    protected ObjectStorage $quiz;

    /**
     * @var ObjectStorage<CourseMaterial>
     */
    #[Extbase\ORM\OneToMany(mappedBy: 'lesson', cascade: ['remove'])]
    protected ObjectStorage $materials;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        parent::__construct();
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
        $this->pages = new ObjectStorage();
        $this->quiz = new ObjectStorage();
        $this->materials = new ObjectStorage();
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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): void
    {
        $this->introduction = $introduction;
    }

    public function getExpectedDuration(): int
    {
        return $this->expectedDuration;
    }

    public function setExpectedDuration(int $expectedDuration): void
    {
        $this->expectedDuration = $expectedDuration;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): void
    {
        $this->module = $module;
    }

    /**
     * @return ObjectStorage<LessonContentPage>
     */
    public function getPages(): ObjectStorage
    {
        return $this->pages;
    }

    public function addPage(LessonContentPage $page): void
    {
        if (!$this->pages->contains($page)) {
            $this->pages->attach($page);
        }
    }

    public function removePage(LessonContentPage $page): void
    {
        if ($this->pages->contains($page)) {
            $this->pages->detach($page);
        }
    }

    /**
     * @return ObjectStorage<LessonQuestion>
     */
    public function getQuiz(): ObjectStorage
    {
        return $this->quiz;
    }

    public function addQuizQuestion(LessonQuestion $question): void
    {
        if (!$this->quiz->contains($question)) {
            $this->quiz->attach($question);
        }
    }

    public function removeQuizQuestion(LessonQuestion $question): void
    {
        if ($this->quiz->contains($question)) {
            $this->quiz->detach($question);
        }
    }

    /**
     * @return ObjectStorage<CourseMaterial>
     */
    public function getMaterials(): ObjectStorage
    {
        return $this->materials;
    }

    public function addMaterial(CourseMaterial $material): void
    {
        if (!$this->materials->contains($material)) {
            $this->materials->attach($material);
        }
    }

    public function removeMaterial(CourseMaterial $material): void
    {
        if ($this->materials->contains($material)) {
            $this->materials->detach($material);
        }
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
