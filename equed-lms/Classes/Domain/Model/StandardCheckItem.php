<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\LanguageCode;
/**
 * Domain model for standard check items.
 */
final class StandardCheckItem extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;
    protected string $titleKey = '';
    protected ?string $titleOverride = null;
    protected ?string $description = null;
    protected bool $isRequired = true;
    protected int $position = 0;
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
            $now            = new DateTimeImmutable();
            $this->createdAt = $now;
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the related course program.
    public function getCourseProgram(): ?CourseProgram
        return $this->courseProgram;
     * Sets the related course program.
     *
     * @param CourseProgram|null $courseProgram
    public function setCourseProgram(?CourseProgram $courseProgram): void
        $this->courseProgram = $courseProgram;
     * Gets the translation key for the title.
    public function getTitleKey(): string
        return $this->titleKey;
     * Sets the translation key for the title.
    public function setTitleKey(string $titleKey): void
        $this->titleKey = $titleKey;
     * Gets the title override.
    public function getTitleOverride(): ?string
        return $this->titleOverride;
     * Sets the title override.
    public function setTitleOverride(?string $titleOverride): void
        $this->titleOverride = $titleOverride;
     * Gets the description.
    public function getDescription(): ?string
        return $this->description;
     * Sets the description.
    public function setDescription(?string $description): void
        $this->description = $description;
     * Checks if the item is required.
    public function isRequired(): bool
        return $this->isRequired;
     * Sets whether the item is required.
    public function setIsRequired(bool $isRequired): void
        $this->isRequired = $isRequired;
     * Gets the position.
    public function getPosition(): int
        return $this->position;
     * Sets the position.
    public function setPosition(int $position): void
        $this->position = $position;
     * Checks if the item is archived.
    public function isArchived(): bool
        return $this->isArchived;
     * Sets the archived state.
    public function setIsArchived(bool $isArchived): void
        $this->isArchived = $isArchived;
     * Gets the language code.
    public function getLanguage(): LanguageCode
        return $this->language;
     * Sets the language code.
    public function setLanguage(LanguageCode $language): void
        $this->language = $language;
     * Gets the creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets the creation timestamp.
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets the last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets the last update timestamp.
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
