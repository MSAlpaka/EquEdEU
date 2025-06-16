<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * DTO representing a user course record.
 */
final class UserCourseRecordDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $uuid,
        private readonly int $courseInstanceId,
        private readonly int $userId,
        private readonly int $attemptNumber,
        private readonly ?string $enrolledAt,
        private readonly ?string $completedAt,
        private readonly ?string $revokedAt,
        private readonly string $certificateNumber,
        private readonly string $certificateHash,
        private readonly string $badgeLevel,
        private readonly string $status,
        private readonly bool $finalized,
        private readonly bool $validatedByCertifier,
        private readonly ?string $certificateIssuedAt,
        private readonly float $progressPercent,
        private readonly ?string $lastActivity,
        private readonly bool $externalCertificateFlag,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCourseInstanceId(): int
    {
        return $this->courseInstanceId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAttemptNumber(): int
    {
        return $this->attemptNumber;
    }

    public function getEnrolledAt(): ?string
    {
        return $this->enrolledAt;
    }

    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    public function getRevokedAt(): ?string
    {
        return $this->revokedAt;
    }

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function getCertificateHash(): string
    {
        return $this->certificateHash;
    }

    public function getBadgeLevel(): string
    {
        return $this->badgeLevel;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isFinalized(): bool
    {
        return $this->finalized;
    }

    public function isValidatedByCertifier(): bool
    {
        return $this->validatedByCertifier;
    }

    public function getCertificateIssuedAt(): ?string
    {
        return $this->certificateIssuedAt;
    }

    public function getProgressPercent(): float
    {
        return $this->progressPercent;
    }

    public function getLastActivity(): ?string
    {
        return $this->lastActivity;
    }

    public function isExternalCertificateFlag(): bool
    {
        return $this->externalCertificateFlag;
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'courseInstanceId' => $this->courseInstanceId,
            'userId' => $this->userId,
            'attemptNumber' => $this->attemptNumber,
            'enrolledAt' => $this->enrolledAt,
            'completedAt' => $this->completedAt,
            'revokedAt' => $this->revokedAt,
            'certificateNumber' => $this->certificateNumber,
            'certificateHash' => $this->certificateHash,
            'badgeLevel' => $this->badgeLevel,
            'status' => $this->status,
            'finalized' => $this->finalized,
            'validatedByCertifier' => $this->validatedByCertifier,
            'certificateIssuedAt' => $this->certificateIssuedAt,
            'progressPercent' => $this->progressPercent,
            'lastActivity' => $this->lastActivity,
            'externalCertificateFlag' => $this->externalCertificateFlag,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
