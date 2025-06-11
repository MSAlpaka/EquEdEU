<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible status values for UserSubmission entities.
 */
enum SubmissionStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case ResubmissionRequested = 'resubmission_requested';
}
