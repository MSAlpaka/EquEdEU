<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Request DTO for submitting course feedback.
 */
final class FeedbackRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $recordId,
        private readonly string $feedback,
        private readonly bool $standardsOk,
        private readonly string $suggestedCourses,
        private readonly int $ratingInstructor,
        private readonly int $ratingLocation,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $feedback = isset($body['feedback']) ? trim((string)$body['feedback']) : '';
        $standardsOk = isset($body['standardsOk']) ? (bool)$body['standardsOk'] : false;
        $suggestedCourses = isset($body['suggestedCourses']) ? trim((string)$body['suggestedCourses']) : '';
        $ratingInstructor = isset($body['ratingInstructor']) ? (int)$body['ratingInstructor'] : 0;
        $ratingLocation = isset($body['ratingLocation']) ? (int)$body['ratingLocation'] : 0;

        if ($userId <= 0 || $recordId <= 0 || $feedback === '') {
            throw new InvalidArgumentException('Invalid feedback submission input');
        }

        return new self(
            $userId,
            $recordId,
            $feedback,
            $standardsOk,
            $suggestedCourses,
            $ratingInstructor,
            $ratingLocation,
        );
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRecordId(): int
    {
        return $this->recordId;
    }

    public function getFeedback(): string
    {
        return $this->feedback;
    }

    public function isStandardsOk(): bool
    {
        return $this->standardsOk;
    }

    public function getSuggestedCourses(): string
    {
        return $this->suggestedCourses;
    }

    public function getRatingInstructor(): int
    {
        return $this->ratingInstructor;
    }

    public function getRatingLocation(): int
    {
        return $this->ratingLocation;
    }
}

