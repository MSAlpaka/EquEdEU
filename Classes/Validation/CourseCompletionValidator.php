<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to check if a UserCourseRecord is eligible for course completion.
 */
final class CourseCompletionValidator extends AbstractValidator
{
    /**
     * Validates that the provided value is a UserCourseRecord ready for completion.
     *
     * @param mixed $value
     */
    public function isValid($value): void
    {
        if (!$value instanceof UserCourseRecord) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.courseCompletion.invalidRecord',
                    'equed_lms'
                ) ?? 'Invalid course record.',
                170101
            );
            return;
        }

        if ($value->getStatus() !== 'submitted') {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.courseCompletion.notSubmitted',
                    'equed_lms'
                ) ?? 'Course must be submitted before completion.',
                170102
            );
        }

        if (!$value->getAllTestsPassed()) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.courseCompletion.testsNotPassed',
                    'equed_lms'
                ) ?? 'Not all tests have been passed successfully.',
                170103
            );
        }

        if (!$value->getInstructorConfirmed()) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.courseCompletion.instructorNotConfirmed',
                    'equed_lms'
                ) ?? 'Instructor must confirm course completion.',
                170104
            );
        }
    }
}
// End of file
