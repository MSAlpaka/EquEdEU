<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * GlossaryTerm
 *
 * Represents a term in the glossary with multilingual support and course tagging.
 */
final class GlossaryTerm extends AbstractEntity
{
    /**
     * Unique identifier
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Display title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * Translation key for title
     *
     * @var string|null
     */
    protected ?string $titleKey = null;

    /**
     * Short explanation for beginners
     *
     * @var string
     */
    protected string $simpleExplanation = '';

    /**
     * Detailed explanation for experts
     *
     * @var string
     */
    protected string $expertExplanation = '';

    /**
     * Language identifier
     *
     * @var string
     */
    protected string $lang = 'en';

    /**
     * Optional icon reference
     *
     * @var string|null
     */
    protected ?string $iconIdentifier = null;

    /**
     * @var ObjectStorage<CourseProgram>
     */
    #[Extbase\ORM\ManyToMany(targetEntity: CourseProgram::class, cascade: ['remove'], lazy: true)]
    protected ObjectStorage $courseTags;

    /**
     * Visibility flag
     *
     * @var bool
     */
    protected bool $visible = true;

    /**
     * Creation timestamp
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = Uuid::uuid4()->toString();
        $now = new DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
        $this->courseTags = new ObjectStorage();
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

    public function getSimpleExplanation(): string
    {
        return $this->simpleExplanation;
    }

    public function setSimpleExplanation(string $simpleExplanation): void
    {
        $this->simpleExplanation = $simpleExplanation;
    }

    public function getExpertExplanation(): string
    {
        return $this->expertExplanation;
    }

    public function setExpertExplanation(string $expertExplanation): void
    {
        $this->expertExplanation = $expertExplanation;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function getIconIdentifier(): ?string
    {
        return $this->iconIdentifier;
    }

    public function setIconIdentifier(?string $iconIdentifier): void
    {
        $this->iconIdentifier = $iconIdentifier;
    }

    /**
     * @return ObjectStorage<CourseProgram>
     */
    public function getCourseTags(): ObjectStorage
    {
        return $this->courseTags;
    }

    public function addCourseTag(CourseProgram $program): void
    {
        if (!$this->courseTags->contains($program)) {
            $this->courseTags->attach($program);
        }
    }

    public function removeCourseTag(CourseProgram $program): void
    {
        if ($this->courseTags->contains($program)) {
            $this->courseTags->detach($program);
        }
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
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
