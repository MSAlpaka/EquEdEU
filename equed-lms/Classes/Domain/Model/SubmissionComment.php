<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for submission comments.
 */
final class SubmissionComment extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?UserSubmission $submission = null;
    protected ?FrontendUser $author = null;
    protected string $comment = '';
    protected LanguageCode $lang = LanguageCode::EN;
    protected bool $visibleForUser = true;
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
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the related submission.
    public function getSubmission(): ?UserSubmission
        return $this->submission;
     * Sets the related submission.
     *
     * @param UserSubmission|null $submission
    public function setSubmission(?UserSubmission $submission): void
        $this->submission = $submission;
     * Gets the author of the comment.
    public function getAuthor(): ?FrontendUser
        return $this->author;
     * Sets the author of the comment.
     * @param FrontendUser|null $author
    public function setAuthor(?FrontendUser $author): void
        $this->author = $author;
     * Gets the comment text.
    public function getComment(): string
        return $this->comment;
     * Sets the comment text.
    public function setComment(string $comment): void
        $this->comment = $comment;
     * Gets the language code.
    public function getLang(): LanguageCode
        return $this->lang;
     * Sets the language code.
    public function setLang(LanguageCode $lang): void
        $this->lang = $lang;
     * Checks if the comment is visible for the user.
    public function isVisibleForUser(): bool
        return $this->visibleForUser;
     * Sets visibility for the user.
    public function setVisibleForUser(bool $visibleForUser): void
        $this->visibleForUser = $visibleForUser;
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
