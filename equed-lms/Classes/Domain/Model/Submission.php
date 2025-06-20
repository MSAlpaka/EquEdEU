<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for submissions.
 */
final class Submission extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $user = null;

    #[ManyToOne]
    #[Lazy]
    protected ?Lesson $lesson = null;

    protected string $title = '';

    protected ?string $description = null;

    protected string $file = '';

    protected DateTimeImmutable $createdAt;

    protected string $gptAnalysisStatus = 'pending';

    protected ?float $gptScore = null;

    protected ?string $gptSummary = null;

    protected ?string $gptSuggestion = null;

    protected ?string $gptAnalysisData = null;

    protected ?DateTimeImmutable $analyzedAt = null;

    protected ?string $textContent = null;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUser(): ?FrontendUser
    {
        return $this->user;
    }

    public function setUser(?FrontendUser $user): void
    {
        $this->user = $user;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
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

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTextContent(): ?string
    {
        return $this->textContent;
    }

    public function setTextContent(?string $textContent): void
    {
        $this->textContent = $textContent;
    }

    public function setGptAnalysisStatus(string $status): void
    {
        $this->gptAnalysisStatus = $status;
    }

    public function setGptScore(?float $score): void
    {
        $this->gptScore = $score;
    }

    public function setGptSummary(?string $summary): void
    {
        $this->gptSummary = $summary;
    }

    public function setGptSuggestion(?string $suggestion): void
    {
        $this->gptSuggestion = $suggestion;
    }

    public function setGptAnalysisData(?string $data): void
    {
        $this->gptAnalysisData = $data;
    }

    public function setAnalyzedAt(?DateTimeImmutable $analyzedAt): void
    {
        $this->analyzedAt = $analyzedAt;
    }
}
