<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\ValidationMode;
use Equed\EquedLms\Enum\LanguageCode;
/**
 * CourseInstance Domain Model
 */
final class CourseInstance extends AbstractEntity
{
    /**
     * UUID generated for this instance
     *
     * @var string
     */
    protected string $uuid = '';
     * Human readable title
    protected string $title = '';
    /** @var DateTimeImmutable|null */
    protected ?DateTimeImmutable $startDate = null;
    protected ?DateTimeImmutable $endDate = null;
     * Course location
    protected string $location = '';
     * Language of instruction
     * @var LanguageCode
    protected LanguageCode $language = LanguageCode::EN;
    /** @var int */
    protected int $seatsTotal = 0;
    /** @var bool */
    protected bool $requiresExternalExaminer = false;
    protected bool $isConfirmed = false;
    protected bool $isVisible = false;
    protected bool $isArchived = false;
     * How validations are handled
    protected ValidationMode $validationMode = ValidationMode::Instructor;
    /** @var int|null */
    protected ?int $accessPolicy = null;
    /** @var string|null */
    protected ?string $tags = null;
    /** @var array */
    protected array $metadata = [];
    /** @var DateTimeImmutable */
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    #[Extbase\ORM\ManyToOne]
    /** @var CourseProgram|null */
    protected ?CourseProgram $courseProgram = null;
    /** @var FrontendUser|null */
    protected ?FrontendUser $instructor = null;
    #[Extbase\ORM\ManyToOne(nullable: true)]
    protected ?FrontendUser $externalExaminer = null;
    #[Extbase\ORM\OneToMany(mappedBy: 'courseInstance', cascade: ['persist'])]
    /** @var ObjectStorage<UserCourseRecord> */
    protected ObjectStorage $userCourseRecords;
    /** @var ObjectStorage<UserSubmission> */
    protected ObjectStorage $submissions;
    public function __construct()
    {
        $this->userCourseRecords = new ObjectStorage();
        $this->submissions = new ObjectStorage();
    }
    public function initializeObject(): void
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
    public function getUuid(): string
        return $this->uuid;
    public function setUuid(string $uuid): void
        $this->uuid = $uuid;
    public function getTitle(): string
        return $this->title;
    public function setTitle(string $title): void
        $this->title = $title;
    public function getStartDate(): ?DateTimeImmutable
        return $this->startDate;
    public function setStartDate(?DateTimeImmutable $startDate): void
        $this->startDate = $startDate;
    public function getEndDate(): ?DateTimeImmutable
        return $this->endDate;
    public function setEndDate(?DateTimeImmutable $endDate): void
        $this->endDate = $endDate;
    public function getLocation(): string
        return $this->location;
    public function setLocation(string $location): void
        $this->location = $location;
    public function getLanguage(): LanguageCode
        return $this->language;
    public function setLanguage(LanguageCode $language): void
        $this->language = $language;
    public function getSeatsTotal(): int
        return $this->seatsTotal;
    public function setSeatsTotal(int $seatsTotal): void
        $this->seatsTotal = $seatsTotal;
    public function getSeatsAvailable(): int
        return max(0, $this->seatsTotal - $this->userCourseRecords->count());
    public function requiresExternalExaminer(): bool
        return $this->requiresExternalExaminer;
    public function setRequiresExternalExaminer(bool $requires): void
        $this->requiresExternalExaminer = $requires;
    public function isConfirmed(): bool
        return $this->isConfirmed;
    public function setConfirmed(bool $confirmed): void
        $this->isConfirmed = $confirmed;
    public function isVisible(): bool
        return $this->isVisible;
    public function setVisible(bool $visible): void
        $this->isVisible = $visible;
    public function isArchived(): bool
        return $this->isArchived;
    public function setArchived(bool $archived): void
        $this->isArchived = $archived;
    public function isUpcoming(): bool
        return $this->startDate !== null && $this->startDate > new DateTimeImmutable();
    public function isActive(): bool
        return $this->startDate !== null && $this->endDate !== null
            && $this->startDate <= $now
            && $this->endDate >= $now;
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
    public function updateTimestamps(): void
        $this->updatedAt = new DateTimeImmutable();
    public function getCourseProgram(): ?CourseProgram
        return $this->courseProgram;
    public function setCourseProgram(?CourseProgram $courseProgram): void
        $this->courseProgram = $courseProgram;
    public function getInstructor(): ?FrontendUser
        return $this->instructor;
    public function setInstructor(?FrontendUser $instructor): void
        $this->instructor = $instructor;
    public function getExternalExaminer(): ?FrontendUser
        return $this->externalExaminer;
    public function setExternalExaminer(?FrontendUser $externalExaminer): void
        $this->externalExaminer = $externalExaminer;
    public function getUserCourseRecords(): ObjectStorage
        return $this->userCourseRecords;
    public function getParticipantCount(): int
        return $this->userCourseRecords->count();
    public function addUserCourseRecord(UserCourseRecord $record): void
        if (!$this->userCourseRecords->contains($record)) {
            $this->userCourseRecords->attach($record);
    public function removeUserCourseRecord(UserCourseRecord $record): void
        if ($this->userCourseRecords->contains($record)) {
            $this->userCourseRecords->detach($record);
    public function getSubmissions(): ObjectStorage
        return $this->submissions;
    public function setSubmissions(ObjectStorage $submissions): void
        $this->submissions = $submissions;
    public function getValidationMode(): ValidationMode
        return $this->validationMode;
    public function setValidationMode(ValidationMode $validationMode): void
        $this->validationMode = $validationMode;
    public function getAccessPolicy(): ?int
        return $this->accessPolicy;
    public function setAccessPolicy(?int $accessPolicy): void
        $this->accessPolicy = $accessPolicy;
    public function getTags(): ?string
        return $this->tags;
    public function setTags(?string $tags): void
        $this->tags = $tags;
    public function getMetadata(): array
        return $this->metadata;
    public function setMetadata(array $metadata): void
        $this->metadata = $metadata;
}
