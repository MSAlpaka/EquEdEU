<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Dto\FeedbackRequest;

/**
 * Handles submission and retrieval of course feedback.
 */
interface FeedbackServiceInterface
{
    /**
     * Submit feedback for a course record.
     */
    public function submitFeedback(FeedbackRequest $request): void;

    /**
     * Check whether feedback for the given user and record exists.
     */
    public function isFeedbackSubmitted(int $userId, int $recordId): bool;
}

