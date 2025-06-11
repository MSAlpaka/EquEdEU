<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\UserSubmission;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to ensure a UserSubmission is valid before processing.
 */
final class ValidSubmissionValidator extends AbstractValidator
{
    /**
     * Validates that the provided value is a UserSubmission with required properties.
     *
     * @param mixed $value The value to validate
     */
    public function isValid($value): void
    {
        if (!$value instanceof UserSubmission) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.submission.invalidType',
                    'equed_lms'
                ) ?? 'Invalid submission record.',
                170001
            );
            return;
        }

        if (empty($value->getTitle())) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.submission.missingTitle',
                    'equed_lms'
                ) ?? 'A title is required for the submission.',
                170002
            );
        }

        if ($value->getFileReference() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.submission.noFile',
                    'equed_lms'
                ) ?? 'At least one document must be uploaded.',
                170003
            );
        }

        if ($value->getCourseInstance() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.submission.noCourseInstance',
                    'equed_lms'
                ) ?? 'The submission must be assigned to a course instance.',
                170004
            );
        }
    }
}
// EOF
