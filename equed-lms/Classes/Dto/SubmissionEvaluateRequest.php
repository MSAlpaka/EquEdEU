<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Psr\Http\Message\ServerRequestInterface;

final class SubmissionEvaluateRequest
{
    public function __construct(
        private readonly int $submissionId,
        private readonly int $evaluatorId,
        private readonly string $evaluationNote,
        private readonly string $evaluationFile,
        private readonly string $comment,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $evaluatorId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();

        $submissionId = isset($body['submissionId']) ? (int)$body['submissionId'] : 0;
        $evaluationNote = isset($body['evaluationNote']) ? trim((string)$body['evaluationNote']) : '';
        $evaluationFile = isset($body['evaluationFile']) ? trim((string)$body['evaluationFile']) : '';
        $comment = isset($body['instructorComment']) ? trim((string)$body['instructorComment']) : '';

        return new self($submissionId, $evaluatorId, $evaluationNote, $evaluationFile, $comment);
    }

    public function getSubmissionId(): int
    {
        return $this->submissionId;
    }

    public function getEvaluatorId(): int
    {
        return $this->evaluatorId;
    }

    public function getEvaluationNote(): string
    {
        return $this->evaluationNote;
    }

    public function getEvaluationFile(): string
    {
        return $this->evaluationFile;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}
