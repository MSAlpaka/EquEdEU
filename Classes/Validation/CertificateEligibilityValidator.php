<?php

declare(strict_types=1);

namespace Equed\EquedLms\Validation;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Validator to check if a UserCourseRecord is eligible for certificate issuance.
 */
final class CertificateEligibilityValidator extends AbstractValidator
{
    /**
     * Validates that the value is a UserCourseRecord eligible for certification.
     *
     * @param mixed $value The value to validate
     * @return void
     */
    public function isValid($value): void
    {
        if (!$value instanceof UserCourseRecord) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.certificateEligibility.invalidRecord',
                    'equed_lms'
                ) ?? 'Invalid course record.',
                170201
            );
            return;
        }

        if ($value->getStatus() !== \Equed\EquedLms\Enum\UserCourseStatus::Validated) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.certificateEligibility.notValidated',
                    'equed_lms'
                ) ?? 'Course has not been validated by certifier.',
                170202
            );
        }

        if ($value->getCompletionDate() === null) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.certificateEligibility.noCompletionDate',
                    'equed_lms'
                ) ?? 'No confirmed completion date available.',
                170203
            );
        }

        if (!$value->meetsAllCertificateCriteria()) {
            $this->addError(
                LocalizationUtility::translate(
                    'validator.certificateEligibility.criteriaNotMet',
                    'equed_lms'
                ) ?? 'Not all certificate criteria have been met.',
                170204
            );
        }
    }
}
// End of file
