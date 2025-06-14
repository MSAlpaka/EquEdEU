<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible status values for SubmissionReview entities.
 */
enum SubmissionReviewStatus: string
{
    case Open = 'open';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
