<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for training records.
 */
final class TrainingRecord extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    protected string $trainingType = 'self';
    protected ?string $trainingTypeKey = null;

    protected string $title = '';
    protected ?string $titleKey = null;

    protected ?string $description = null;
    protected ?string $descriptionKey = null;

    protected float $durationHours = 0.0;

    protected DateTimeImmutable $date;

    #[ManyToOne]
    #[Lazy]
    #[Cascade('remove')]
    protected ?FileReference $proofDocument = null;

    protected bool $isValidated = false;
    protected ?string $validatedBy = null;

    protected string $lang = 'en';

    protected bool $isArchived = false;

    protected int $finalScore = 0;

    protected bool $certificateIssued = false;

    protected string $certificateNumber = '';

    protected ?DateTimeImmutable $certificateIssuedAt = null;

    protected string $gptEvaluationData = '';

    protected bool $feedbackReceived = false;

    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID, date and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }
        $now = $this->clock->now();
        if (!isset($this->date)) {
            $this->date = $now;
        }
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
    }

    /**
     * Gets the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the user course record.
     */
    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Sets the user course record.
     *
     * @param UserCourseRecord|null $userCourseRecord
     */
    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    /**
     * Gets the training type.
     */
    public function getTrainingType(): string
    {
        return $this->trainingType;
    }

    /**
     * Sets the training type.
     */
    public function setTrainingType(string $trainingType): void
    {
        $this->trainingType = $trainingType;
    }

    /**
     * Gets the translation key for training type.
     */
    public function getTrainingTypeKey(): ?string
    {
        return $this->trainingTypeKey;
    }

    /**
     * Sets the translation key for training type.
     */
    public function setTrainingTypeKey(?string $trainingTypeKey): void
    {
        $this->trainingTypeKey = $trainingTypeKey;
    }

    /**
     * Gets the title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the translation key for title.
     */
    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    /**
     * Sets the translation key for title.
     */
    public function setTitleKey(?string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    /**
     * Gets the description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description.
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets the translation key for description.
     */
    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    /**
     * Sets the translation key for description.
     */
    public function setDescriptionKey(?string $descriptionKey): void
    {
        $this->descriptionKey = $descriptionKey;
    }

    /**
     * Gets the duration in hours.
     */
    public function getDurationHours(): float
    {
        return $this->durationHours;
    }

    /**
     * Sets the duration in hours.
     */
    public function setDurationHours(float $durationHours): void
    {
        $this->durationHours = $durationHours;
    }

    /**
     * Gets the date of training.
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * Sets the date of training.
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    /**
     * Gets the proof document.
     */
    public function getProofDocument(): ?FileReference
    {
        return $this->proofDocument;
    }

    /**
     * Sets the proof document.
     *
     * @param FileReference|null $proofDocument
     */
    public function setProofDocument(?FileReference $proofDocument): void
    {
        $this->proofDocument = $proofDocument;
    }

    /**
     * Checks if the record is validated.
     */
    public function isValidated(): bool
    {
        return $this->isValidated;
    }

    /**
     * Sets the validated state.
     */
    public function setIsValidated(bool $isValidated): void
    {
        $this->isValidated = $isValidated;
    }

    /**
     * Gets who validated the record.
     */
    public function getValidatedBy(): ?string
    {
        return $this->validatedBy;
    }

    /**
     * Sets who validated the record.
     */
    public function setValidatedBy(?string $validatedBy): void
    {
        $this->validatedBy = $validatedBy;
    }

    /**
     * Gets the language code.
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * Sets the language code.
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Checks if the record is archived.
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * Sets the archived state.
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    public function getFinalScore(): int
    {
        return $this->finalScore;
    }

    public function setFinalScore(int $finalScore): void
    {
        $this->finalScore = $finalScore;
    }

    public function isCertificateIssued(): bool
    {
        return $this->certificateIssued;
    }

    public function setCertificateIssued(bool $certificateIssued): void
    {
        $this->certificateIssued = $certificateIssued;
    }

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function setCertificateNumber(string $certificateNumber): void
    {
        $this->certificateNumber = $certificateNumber;
    }

    public function getCertificateIssuedAt(): ?DateTimeImmutable
    {
        return $this->certificateIssuedAt;
    }

    public function setCertificateIssuedAt(?DateTimeImmutable $certificateIssuedAt): void
    {
        $this->certificateIssuedAt = $certificateIssuedAt;
    }

    public function getGptEvaluationData(): string
    {
        return $this->gptEvaluationData;
    }

    public function setGptEvaluationData(string $gptEvaluationData): void
    {
        $this->gptEvaluationData = $gptEvaluationData;
    }

    public function isFeedbackReceived(): bool
    {
        return $this->feedbackReceived;
    }

    public function setFeedbackReceived(bool $feedbackReceived): void
    {
        $this->feedbackReceived = $feedbackReceived;
    }

    /**
     * Gets the creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
