<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\UserProfile;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to check if a UserProfile qualifies for recognition awards.
 */
final class RecognitionAwardValidator extends AbstractValidator
{
    /**
     * Validates that the provided value is a UserProfile eligible for recognition award.
     *
     * @param mixed $value The value to validate
     */
    public function isValid($value): void
    {
        if (!$value instanceof UserProfile) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.recognitionAward.invalidProfile',
                    'equed_lms'
                ) ?? 'Invalid user profile.',
                170501
            );
            return;
        }

        if ($value->getCompletedSpecialtiesCount() < 4) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.recognitionAward.minSpecialties',
                    'equed_lms'
                ) ?? 'At least 4 certified specialties are required.',
                170502
            );
        }

        if ($value->getPracticeHours() < 100) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.recognitionAward.minPracticeHours',
                    'equed_lms'
                ) ?? 'At least 100 practice hours are necessary for the award.',
                170503
            );
        }
    }
}
// EOF
