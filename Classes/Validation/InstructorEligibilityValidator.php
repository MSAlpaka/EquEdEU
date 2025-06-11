<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\UserProfile;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to check if a UserProfile is eligible for the Instructor role.
 */
final class InstructorEligibilityValidator extends AbstractValidator
{
    /**
     * Validates that the provided value is a UserProfile eligible for instructor role.
     *
     * @param mixed $value
     */
    public function isValid($value): void
    {
        if (!$value instanceof UserProfile) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.instructorEligibility.invalidProfile',
                    'equed_lms'
                ) ?? 'Invalid user profile.',
                170401
            );
            return;
        }

        if (
            !$value->hasCompletedInstructorSeminar()
            && !$value->hasCrossoverProof()
            && !$value->hasCoTeachingExperience()
        ) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.instructorEligibility.prerequisitesNotMet',
                    'equed_lms'
                ) ?? 'Prerequisites for instructor role not met.',
                170402
            );
        }

        if (!$value->hasCompletedRequiredCourses()) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.instructorEligibility.missingRequiredCourses',
                    'equed_lms'
                ) ?? 'Required courses for instructor role are missing.',
                170403
            );
        }
    }
}
// End of file
