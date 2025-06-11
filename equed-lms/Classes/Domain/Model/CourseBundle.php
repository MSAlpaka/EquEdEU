<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToMany;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Equed\EquedLms\Domain\Model\CourseProgram;

/**
 * Represents a bundle of courses offered together.
 */
final class CourseBundle extends AbstractEntity
{
    protected string $uuid;

    protected string $title = '';

    protected ?string $titleKey = null;

    protected ?string $description = null;

    protected ?string $descriptionKey = null;

    protected DateTimeImmutable $availableFrom;

    protected bool $hidden = false;

    /**
     * @var ObjectStorage<CourseProgram>
     */
    #[ManyToMany(targetEntity: CourseProgram::class, cascade: ['remove'], lazy: true)]
    protected ObjectStorage $coursePrograms;

    protected float $price = 0.0;

    protected int $discountPercentage = 0;

    protected bool $isActive = true;

    protected bool $isVisible = true;

    protected string $slug = '';

    /**
     * @var FileReference|null
     */
    #[Cascade('remove')]
    #[Lazy]
    protected ?FileReference $image = null;

    protected ?int $recommendedAfter = null;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->availableFrom = $now;
        $this->coursePrograms = new ObjectStorage();
        $this->createdAt = $now;
        $this->updatedAt = $now;
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

    public function getAvailableFrom(): DateTimeImmutable
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(DateTimeImmutable $availableFrom): void
    {
        $this->availableFrom = $availableFrom;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(?FileReference $image): void
    {
        $this->image = $image;
    }

    public function getRecommendedAfter(): ?int
    {
        return $this->recommendedAfter;
    }

    public function setRecommendedAfter(?int $recommendedAfter): void
    {
        $this->recommendedAfter = $recommendedAfter;
    }

    /**
     * @return ObjectStorage<CourseProgram>
     */
    public function getCoursePrograms(): ObjectStorage
    {
        return $this->coursePrograms;
    }

    public function addCourseProgram(CourseProgram $program): void
    {
        if (!$this->coursePrograms->contains($program)) {
            $this->coursePrograms->attach($program);
        }
    }

    public function removeCourseProgram(CourseProgram $program): void
    {
        if ($this->coursePrograms->contains($program)) {
            $this->coursePrograms->detach($program);
        }
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getDiscountPercentage(): int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function setVisible(bool $isVisible): void
    {
        $this->isVisible = $isVisible;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
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
