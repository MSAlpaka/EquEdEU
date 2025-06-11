<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\LessonAttempt;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to ensure a LessonAttempt is valid before processing.
 */
final class LessonAttemptValidator extends AbstractValidator
{
    /**
     * Validates that the provided value is a LessonAttempt with required properties.
     *
     * @param mixed $value The value to validate
     */
    public function isValid($value): void
    {
        if (!$value instanceof LessonAttempt) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.lessonAttempt.invalidType',
                    'equed_lms'
                ) ?? 'Invalid lesson attempt.',
                170301
            );
            return;
        }

        if ($value->getLesson() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.lessonAttempt.noLesson',
                    'equed_lms'
                ) ?? 'Lesson attempt must be associated with a lesson.',
                170302
            );
        }

        if ($value->getStartTime() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.lessonAttempt.missingStartTime',
                    'equed_lms'
                ) ?? 'Start time is required.',
                170303
            );
        }

        if ($value->isSubmitted() && $value->getEndTime() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.lessonAttempt.missingEndTime',
                    'equed_lms'
                ) ?? 'Submitted attempts must have an end time.',
                170304
            );
        }
    }
}
// EOF
