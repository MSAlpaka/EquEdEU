<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * DTO representing a review of a user submission.
 */
final class SubmissionReviewDto implements \JsonSerializable
{
    public function __construct(
        private readonly string $uuid,
        private readonly ?int $submissionId,
        private readonly ?int $reviewedBy,
        private readonly string $status,
        private readonly ?string $comment,
        private readonly ?string $evaluationDocumentUrl,
        private readonly bool $visibleForUser,
        private readonly bool $generatedByGpt,
        private readonly string $lang,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSubmissionId(): ?int
    {
        return $this->submissionId;
    }

    public function getReviewedBy(): ?int
    {
        return $this->reviewedBy;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getEvaluationDocumentUrl(): ?string
    {
        return $this->evaluationDocumentUrl;
    }

    public function isVisibleForUser(): bool
    {
        return $this->visibleForUser;
    }

    public function isGeneratedByGpt(): bool
    {
        return $this->generatedByGpt;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'submissionId' => $this->submissionId,
            'reviewedBy' => $this->reviewedBy,
            'status' => $this->status,
            'comment' => $this->comment,
            'evaluationDocumentUrl' => $this->evaluationDocumentUrl,
            'visibleForUser' => $this->visibleForUser,
            'generatedByGpt' => $this->generatedByGpt,
            'lang' => $this->lang,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
