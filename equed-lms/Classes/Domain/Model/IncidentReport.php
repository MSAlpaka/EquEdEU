<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * IncidentReport
 *
 * @package Equed\EquedLms\Domain\Model
 */
final class IncidentReport extends AbstractEntity
{
    /** Unique identifier */
    protected string $uuid;

    /** Related user course record */
    #[ManyToOne, Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    /** Course instance */
    #[ManyToOne, Lazy]
    protected ?CourseInstance $courseInstance = null;

    /** Instructor involved */
    #[ManyToOne, Lazy]
    protected ?FrontendUser $instructor = null;

    /** Certifier involved */
    #[ManyToOne, Lazy]
    protected ?FrontendUser $certifier = null;

    /** User the report concerns */
    #[ManyToOne, Lazy]
    protected ?FrontendUser $reportedUser = null;

    /** Key describing the type of incident */
    protected string $incidentTypeKey = '';

    /** Severity classification */
    protected string $severityKey = '';

    /** Current processing status */
    protected string $status = 'open';

    /** Optional comment by instructor */
    protected ?string $commentInstructor = null;

    /** Optional comment by service center */
    protected ?string $commentServiceCenter = null;

    /** Optional comment by certifier */
    protected ?string $commentCertifier = null;

    /** Linked certificate number if any */
    protected ?string $linkedCertificateNumber = null;

    /** Linked training standard key if any */
    protected ?string $linkedStandardKey = null;

    /** Whether instructor may view the report */
    protected bool $visibleToInstructor = true;

    /** Whether training center may view the report */
    protected bool $visibleToTrainingCenter = true;

    /** Whether certifier may view the report */
    protected bool $visibleToCertifier = true;

    /** Archive flag */
    protected bool $isArchived = false;

    /** Creation timestamp */
    protected DateTimeImmutable $createdAt;

    /** Last update timestamp */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        parent::__construct();
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    public function setUserCourseRecord(?UserCourseRecord $record): void
    {
        $this->userCourseRecord = $record;
    }

    public function getCourseInstance(): ?CourseInstance
    {
        return $this->courseInstance;
    }

    public function setCourseInstance(?CourseInstance $instance): void
    {
        $this->courseInstance = $instance;
    }

    public function getInstructor(): ?FrontendUser
    {
        return $this->instructor;
    }

    public function setInstructor(?FrontendUser $instructor): void
    {
        $this->instructor = $instructor;
    }

    public function getCertifier(): ?FrontendUser
    {
        return $this->certifier;
    }

    public function setCertifier(?FrontendUser $certifier): void
    {
        $this->certifier = $certifier;
    }

    public function getReportedUser(): ?FrontendUser
    {
        return $this->reportedUser;
    }

    public function setReportedUser(?FrontendUser $user): void
    {
        $this->reportedUser = $user;
    }

    public function getIncidentTypeKey(): string
    {
        return $this->incidentTypeKey;
    }

    public function setIncidentTypeKey(string $key): void
    {
        $this->incidentTypeKey = $key;
    }

    public function getSeverityKey(): string
    {
        return $this->severityKey;
    }

    public function setSeverityKey(string $key): void
    {
        $this->severityKey = $key;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCommentInstructor(): ?string
    {
        return $this->commentInstructor;
    }

    public function setCommentInstructor(?string $comment): void
    {
        $this->commentInstructor = $comment;
    }

    public function getCommentServiceCenter(): ?string
    {
        return $this->commentServiceCenter;
    }

    public function setCommentServiceCenter(?string $comment): void
    {
        $this->commentServiceCenter = $comment;
    }

    public function getCommentCertifier(): ?string
    {
        return $this->commentCertifier;
    }

    public function setCommentCertifier(?string $comment): void
    {
        $this->commentCertifier = $comment;
    }

    public function getLinkedCertificateNumber(): ?string
    {
        return $this->linkedCertificateNumber;
    }

    public function setLinkedCertificateNumber(?string $number): void
    {
        $this->linkedCertificateNumber = $number;
    }

    public function getLinkedStandardKey(): ?string
    {
        return $this->linkedStandardKey;
    }

    public function setLinkedStandardKey(?string $key): void
    {
        $this->linkedStandardKey = $key;
    }

    public function isVisibleToInstructor(): bool
    {
        return $this->visibleToInstructor;
    }

    public function setVisibleToInstructor(bool $visible): void
    {
        $this->visibleToInstructor = $visible;
    }

    public function isVisibleToTrainingCenter(): bool
    {
        return $this->visibleToTrainingCenter;
    }

    public function setVisibleToTrainingCenter(bool $visible): void
    {
        $this->visibleToTrainingCenter = $visible;
    }

    public function isVisibleToCertifier(): bool
    {
        return $this->visibleToCertifier;
    }

    public function setVisibleToCertifier(bool $visible): void
    {
        $this->visibleToCertifier = $visible;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $archived): void
    {
        $this->isArchived = $archived;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $dateTime): void
    {
        $this->createdAt = $dateTime;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $dateTime): void
    {
        $this->updatedAt = $dateTime;
    }
}
