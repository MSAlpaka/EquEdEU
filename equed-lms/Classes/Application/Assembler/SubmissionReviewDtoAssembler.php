<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\SubmissionReviewDto;
use Equed\EquedLms\Domain\Model\SubmissionReview;
use Equed\EquedLms\Domain\Model\UserSubmission;

final class SubmissionReviewDtoAssembler
{
    public static function fromEntity(SubmissionReview $review): SubmissionReviewDto
    {
        return new SubmissionReviewDto(
            $review->getUuid(),
            $review->getSubmission()?->getUid(),
            $review->getReviewedBy()?->getUid(),
            $review->getStatus(),
            $review->getComment(),
            $review->getEvaluationDocument()?->getPublicUrl(),
            $review->isVisibleForUser(),
            $review->isGeneratedByGpt(),
            $review->getLang(),
            $review->getCreatedAt()->format(DATE_ATOM),
            $review->getUpdatedAt()->format(DATE_ATOM),
        );
    }

    public static function fromSubmission(UserSubmission $submission): SubmissionReviewDto
    {
        return new SubmissionReviewDto(
            $submission->getUuid(),
            $submission->getUid(),
            null,
            $submission->getStatus()->value,
            $submission->getInstructorComment(),
            $submission->getInstructorFeedbackFile()?->getPublicUrl(),
            true,
            false,
            'en',
            $submission->getCreatedAt()->format(DATE_ATOM),
            $submission->getUpdatedAt()->format(DATE_ATOM),
        );
    }
}
