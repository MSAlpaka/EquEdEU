<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Equed\EquedLms\Enum\QmsCaseStatus;
use Equed\EquedLms\Enum\QmsCaseType;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\LanguageCode;
/**
 * Domain model for QMS cases.
 */
final class QmsCase extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;
    protected ?CourseInstance $courseInstance = null;
    protected ?FrontendUser $certifier = null;
    #[Cascade('remove')]
    protected ?IncidentReport $incidentReport = null;
    protected ?FrontendUser $finalizedBy = null;
    protected string $title = '';
    protected ?string $titleKey = null;
    protected QmsCaseType $caseType = QmsCaseType::Violation;
    protected QmsCaseStatus $status = QmsCaseStatus::Open;
    protected string $priority = 'normal';
    protected bool $violatesStandard = false;
    protected ?string $standardReference = null;
    protected ?string $comment = null;
    protected ?string $decision = null;
    protected ?FileReference $attachment = null;
    protected bool $visibleToInstructor = true;
    protected bool $visibleToTrainingCenter = true;
    protected bool $visibleToCertifier = true;
    protected bool $isArchived = false;
    protected LanguageCode $language = LanguageCode::EN;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        if (!isset($this->createdAt)) {
            $now = new DateTimeImmutable();
            $this->createdAt = $now;
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the associated user course record.
    public function getUserCourseRecord(): ?UserCourseRecord
        return $this->userCourseRecord;
     * Sets the associated user course record.
    public function setUserCourseRecord(?UserCourseRecord $record): void
        $this->userCourseRecord = $record;
     * Gets the associated course instance.
    public function getCourseInstance(): ?CourseInstance
        return $this->courseInstance;
     * Sets the associated course instance.
    public function setCourseInstance(?CourseInstance $courseInstance): void
        $this->courseInstance = $courseInstance;
     * Gets the certifier.
    public function getCertifier(): ?FrontendUser
        return $this->certifier;
     * Sets the certifier.
    public function setCertifier(?FrontendUser $certifier): void
        $this->certifier = $certifier;
     * Gets the incident report.
    public function getIncidentReport(): ?IncidentReport
        return $this->incidentReport;
     * Sets the incident report.
    public function setIncidentReport(?IncidentReport $incidentReport): void
        $this->incidentReport = $incidentReport;
     * Gets who finalized the case.
    public function getFinalizedBy(): ?FrontendUser
        return $this->finalizedBy;
     * Sets who finalized the case.
    public function setFinalizedBy(?FrontendUser $user): void
        $this->finalizedBy = $user;
     * Gets the case title.
    public function getTitle(): string
        return $this->title;
     * Sets the case title.
    public function setTitle(string $title): void
        $this->title = $title;
     * Gets the translation key for the title.
    public function getTitleKey(): ?string
        return $this->titleKey;
     * Sets the translation key for the title.
    public function setTitleKey(?string $key): void
        $this->titleKey = $key;
     * Gets the case type.
    public function getCaseType(): QmsCaseType
        return $this->caseType;
     * Sets the case type.
    public function setCaseType(QmsCaseType|string $caseType): void
        if (is_string($caseType)) {
            $caseType = QmsCaseType::from($caseType);
        $this->caseType = $caseType;
     * Gets the case status.
    public function getStatus(): QmsCaseStatus
        return $this->status;
     * Sets the case status.
    public function setStatus(QmsCaseStatus|string $status): void
        if (is_string($status)) {
            $status = QmsCaseStatus::from($status);
        $this->status = $status;
     * Gets the priority.
    public function getPriority(): string
        return $this->priority;
     * Sets the priority.
    public function setPriority(string $priority): void
        $this->priority = $priority;
     * Checks if it violates a standard.
    public function violatesStandard(): bool
        return $this->violatesStandard;
     * Sets whether it violates a standard.
    public function setViolatesStandard(bool $violates): void
        $this->violatesStandard = $violates;
     * Gets the standard reference.
    public function getStandardReference(): ?string
        return $this->standardReference;
     * Sets the standard reference.
    public function setStandardReference(?string $reference): void
        $this->standardReference = $reference;
     * Gets the comment.
    public function getComment(): ?string
        return $this->comment;
     * Sets the comment.
    public function setComment(?string $comment): void
        $this->comment = $comment;
     * Gets the decision.
    public function getDecision(): ?string
        return $this->decision;
     * Sets the decision.
    public function setDecision(?string $decision): void
        $this->decision = $decision;
     * Gets the attachment.
    public function getAttachment(): ?FileReference
        return $this->attachment;
     * Sets the attachment.
    public function setAttachment(?FileReference $attachment): void
        $this->attachment = $attachment;
     * Checks if case is visible to instructor.
    public function isVisibleToInstructor(): bool
        return $this->visibleToInstructor;
     * Sets visibility to instructor.
    public function setVisibleToInstructor(bool $visible): void
        $this->visibleToInstructor = $visible;
     * Checks if case is visible to training center.
    public function isVisibleToTrainingCenter(): bool
        return $this->visibleToTrainingCenter;
     * Sets visibility to training center.
    public function setVisibleToTrainingCenter(bool $visible): void
        $this->visibleToTrainingCenter = $visible;
     * Checks if case is visible to certifier.
    public function isVisibleToCertifier(): bool
        return $this->visibleToCertifier;
     * Sets visibility to certifier.
    public function setVisibleToCertifier(bool $visible): void
        $this->visibleToCertifier = $visible;
     * Checks if case is archived.
    public function isArchived(): bool
        return $this->isArchived;
     * Sets archived state.
    public function setIsArchived(bool $archived): void
        $this->isArchived = $archived;
     * Gets the language code.
    public function getLanguage(): LanguageCode
        return $this->language;
     * Sets the language code.
    public function setLanguage(LanguageCode $language): void
        $this->language = $language;
     * Gets creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets creation timestamp.
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets last update timestamp.
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
