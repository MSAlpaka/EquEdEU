<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for practice tests.
 */
final class PracticeTest extends AbstractEntity
{
    protected string $uuid = '';
    protected string $title = '';
    protected ?string $description = null;
    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;
    protected bool $gptEvaluationEnabled = false;
    protected ?string $evaluationScheme = null;
    protected ?string $expectedFileTypes = null;
    protected ?DateTimeImmutable $visibleFrom = null;
    protected ?DateTimeImmutable $visibleUntil = null;
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
     * Gets the title.
    public function getTitle(): string
        return $this->title;
     * Sets the title.
     *
     * @param string $title
    public function setTitle(string $title): void
        $this->title = $title;
     * Gets the description.
    public function getDescription(): ?string
        return $this->description;
     * Sets the description.
     * @param string|null $description
    public function setDescription(?string $description): void
        $this->description = $description;
     * Gets the related course program.
    public function getCourseProgram(): ?CourseProgram
        return $this->courseProgram;
     * Sets the related course program.
     * @param CourseProgram|null $courseProgram
    public function setCourseProgram(?CourseProgram $courseProgram): void
        $this->courseProgram = $courseProgram;
     * Checks if GPT evaluation is enabled.
    public function isGptEvaluationEnabled(): bool
        return $this->gptEvaluationEnabled;
     * Enables or disables GPT evaluation.
     * @param bool $enabled
    public function setGptEvaluationEnabled(bool $enabled): void
        $this->gptEvaluationEnabled = $enabled;
     * Gets the evaluation scheme.
    public function getEvaluationScheme(): ?string
        return $this->evaluationScheme;
     * Sets the evaluation scheme.
     * @param string|null $scheme
    public function setEvaluationScheme(?string $scheme): void
        $this->evaluationScheme = $scheme;
     * Gets the expected file types.
    public function getExpectedFileTypes(): ?string
        return $this->expectedFileTypes;
     * Sets the expected file types.
     * @param string|null $fileTypes
    public function setExpectedFileTypes(?string $fileTypes): void
        $this->expectedFileTypes = $fileTypes;
     * Gets the visibility start time.
    public function getVisibleFrom(): ?DateTimeImmutable
        return $this->visibleFrom;
     * Sets the visibility start time.
     * @param DateTimeImmutable|null $visibleFrom
    public function setVisibleFrom(?DateTimeImmutable $visibleFrom): void
        $this->visibleFrom = $visibleFrom;
     * Gets the visibility end time.
    public function getVisibleUntil(): ?DateTimeImmutable
        return $this->visibleUntil;
     * Sets the visibility end time.
     * @param DateTimeImmutable|null $visibleUntil
    public function setVisibleUntil(?DateTimeImmutable $visibleUntil): void
        $this->visibleUntil = $visibleUntil;
     * Gets the creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets the creation timestamp.
     * @param DateTimeImmutable $createdAt
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets the last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets the last update timestamp.
     * @param DateTimeImmutable $updatedAt
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
