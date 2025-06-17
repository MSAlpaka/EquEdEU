<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Structured QMS case row data.
 */
final class QmsCaseData implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly int $recordId,
        private readonly string $type,
        private readonly string $message,
        private readonly string $status,
        private readonly int $submittedAt,
        private readonly ?int $respondedAt = null,
        private readonly ?int $closedAt = null,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRecordId(): int
    {
        return $this->recordId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSubmittedAt(): int
    {
        return $this->submittedAt;
    }

    public function getRespondedAt(): ?int
    {
        return $this->respondedAt;
    }

    public function getClosedAt(): ?int
    {
        return $this->closedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'          => $this->id,
            'recordId'    => $this->recordId,
            'type'        => $this->type,
            'message'     => $this->message,
            'status'      => $this->status,
            'submittedAt' => $this->submittedAt,
            'respondedAt' => $this->respondedAt,
            'closedAt'    => $this->closedAt,
        ];
    }
}

// EOF
