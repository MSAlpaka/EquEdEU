<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;
use Equed\EquedLms\Enum\AttachmentType;
use Equed\EquedLms\Enum\AttachmentVisibility;
use Equed\EquedLms\Enum\AttachmentStatus;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for submission attachments.
 */
final class SubmissionAttachment extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?UserSubmission $userSubmission = null;
    #[Cascade('remove')]
    protected ?FileReference $file = null;
    protected string $title = '';
    protected AttachmentType $type = AttachmentType::Fallbericht;
    protected AttachmentVisibility $visibility = AttachmentVisibility::InstructorOnly;
    protected AttachmentStatus $status = AttachmentStatus::Active;
    protected LanguageCode $lang = LanguageCode::EN;
    protected bool $isActive = true;
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
     *
     * @return string
    public function getUuid(): string
        return $this->uuid;
     * Gets the associated user submission.
     * @return UserSubmission|null
    public function getUserSubmission(): ?UserSubmission
        return $this->userSubmission;
     * Sets the associated user submission.
     * @param UserSubmission|null $userSubmission
    public function setUserSubmission(?UserSubmission $userSubmission): void
        $this->userSubmission = $userSubmission;
     * Gets the file reference.
     * @return FileReference|null
    public function getFile(): ?FileReference
        return $this->file;
     * Sets the file reference.
     * @param FileReference|null $file
    public function setFile(?FileReference $file): void
        $this->file = $file;
     * Gets the title.
    public function getTitle(): string
        return $this->title;
     * Sets the title.
     * @param string $title
    public function setTitle(string $title): void
        $this->title = $title;
     * Gets the type of attachment.
    public function getType(): AttachmentType
        return $this->type;
     * Sets the type of attachment.
    public function setType(AttachmentType|string $type): void
        if (is_string($type)) {
            $type = AttachmentType::from($type);
        $this->type = $type;
     * Gets the visibility.
    public function getVisibility(): AttachmentVisibility
        return $this->visibility;
     * Sets the visibility.
    public function setVisibility(AttachmentVisibility|string $visibility): void
        if (is_string($visibility)) {
            $visibility = AttachmentVisibility::from($visibility);
        $this->visibility = $visibility;
     * Gets the status of the attachment.
    public function getStatus(): AttachmentStatus
        return $this->status;
     * Sets the status of the attachment.
    public function setStatus(AttachmentStatus|string $status): void
        if (is_string($status)) {
            $status = AttachmentStatus::from($status);
        $this->status = $status;
     * Gets the language code.
    public function getLang(): LanguageCode
        return $this->lang;
     * Sets the language code.
     * @param LanguageCode $lang
    public function setLang(LanguageCode $lang): void
        $this->lang = $lang;
     * Checks if the attachment is active.
     * @return bool
    public function isActive(): bool
        return $this->isActive;
     * Sets the active state.
     * @param bool $isActive
    public function setIsActive(bool $isActive): void
        $this->isActive = $isActive;
     * Gets the creation timestamp.
     * @return DateTimeImmutable
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
