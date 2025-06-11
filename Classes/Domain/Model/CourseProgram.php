<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\OneToMany;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * CourseProgram
 *
 * Represents a program consisting of one or more course instances.
 */
final class CourseProgram extends AbstractEntity
{
    /**
     * Unique identifier
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Program title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * Optional description
     *
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * Category identifier
     *
     * @var string
     */
    protected string $category = '';

    /**
     * When the program becomes available
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $availableFrom;

    /**
     * Visible flag
     *
     * @var bool
     */
    protected bool $isVisible = true;

    /**
     * Archive flag
     *
     * @var bool
     */
    protected bool $isArchived = false;

    /**
     * Badge icon reference
     *
     * @var FileReference|null
     */
    protected ?FileReference $badgeIcon = null;

    /**
     * Whether an external examiner is required
     *
     * @var bool
     */
    protected bool $requiresExternalExaminer = false;

    /**
     * Certifier must validate results
     *
     * @var bool
     */
    protected bool $certifierMustValidate = false;

    /**
     * Whether recertification is required
     *
     * @var bool
     */
    protected bool $recertificationRequired = false;

    /**
     * Interval in years between recertifications
     *
     * @var int
     */
    protected int $recertificationIntervalYears = 3;

    /**
     * Visible in the course catalog
     *
     * @var bool
     */
    protected bool $visibleInCatalog = true;

    #[OneToMany(mappedBy: 'courseProgram', cascade: ['remove'])]
    #[Lazy]
    /** @var ObjectStorage<CourseInstance> */
    protected ObjectStorage $courseInstances;

    #[OneToMany(mappedBy: 'courseProgram', cascade: ['remove'])]
    #[Lazy]
    /** @var ObjectStorage<CertificateTemplate> */
    protected ObjectStorage $certificateTemplates;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->availableFrom = $now;
        $this->courseInstances = new ObjectStorage();
        $this->certificateTemplates = new ObjectStorage();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getAvailableFrom(): DateTimeImmutable
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(DateTimeImmutable $availableFrom): void
    {
        $this->availableFrom = $availableFrom;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function setVisible(bool $visible): void
    {
        $this->isVisible = $visible;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setArchived(bool $archived): void
    {
        $this->isArchived = $archived;
    }

    public function getBadgeIcon(): ?FileReference
    {
        return $this->badgeIcon;
    }

    public function setBadgeIcon(?FileReference $badgeIcon): void
    {
        $this->badgeIcon = $badgeIcon;
    }

    public function requiresExternalExaminer(): bool
    {
        return $this->requiresExternalExaminer;
    }

    public function setRequiresExternalExaminer(bool $requiresExternalExaminer): void
    {
        $this->requiresExternalExaminer = $requiresExternalExaminer;
    }

    public function certifierMustValidate(): bool
    {
        return $this->certifierMustValidate;
    }

    public function setCertifierMustValidate(bool $certifierMustValidate): void
    {
        $this->certifierMustValidate = $certifierMustValidate;
    }

    public function isRecertificationRequired(): bool
    {
        return $this->recertificationRequired;
    }

    public function setRecertificationRequired(bool $recertificationRequired): void
    {
        $this->recertificationRequired = $recertificationRequired;
    }

    public function getRecertificationIntervalYears(): int
    {
        return $this->recertificationIntervalYears;
    }

    public function setRecertificationIntervalYears(int $recertificationIntervalYears): void
    {
        $this->recertificationIntervalYears = $recertificationIntervalYears;
    }

    public function isVisibleInCatalog(): bool
    {
        return $this->visibleInCatalog;
    }

    public function setVisibleInCatalog(bool $visibleInCatalog): void
    {
        $this->visibleInCatalog = $visibleInCatalog;
    }

    public function getCourseInstances(): ObjectStorage
    {
        return $this->courseInstances;
    }

    public function addCourseInstance(CourseInstance $instance): void
    {
        if (!$this->courseInstances->contains($instance)) {
            $this->courseInstances->attach($instance);
        }
    }

    public function removeCourseInstance(CourseInstance $instance): void
    {
        if ($this->courseInstances->contains($instance)) {
            $this->courseInstances->detach($instance);
        }
    }

    public function getCertificateTemplates(): ObjectStorage
    {
        return $this->certificateTemplates;
    }

    public function addCertificateTemplate(CertificateTemplate $template): void
    {
        if (!$this->certificateTemplates->contains($template)) {
            $this->certificateTemplates->attach($template);
        }
    }

    public function removeCertificateTemplate(CertificateTemplate $template): void
    {
        if ($this->certificateTemplates->contains($template)) {
            $this->certificateTemplates->detach($template);
        }
    }
}
