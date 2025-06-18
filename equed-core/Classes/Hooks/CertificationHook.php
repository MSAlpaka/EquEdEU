<?php

declare(strict_types=1);

namespace Equed\EquedCore\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Equed\EquedCore\Domain\Service\LmsIntegrationServiceInterface;

class CertificationHook
{
    /**
     * @param array<string,mixed> $fieldArray
     * @param array<string,mixed> $incomingFieldArray
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function processDatamap_postProcessFieldArray(
        array $fieldArray,
        string $table,
        int $id,
        array $incomingFieldArray
    ): void {
        // Sync instructor level to LMS if fe_users record was updated
        if ($table === 'fe_users' && array_key_exists('instructor_level', $incomingFieldArray)) {
            $service = GeneralUtility::makeInstance(LmsIntegrationServiceInterface::class);
            $service->syncInstructorLevel($id, (string)$incomingFieldArray['instructor_level']);
        }
    }
    // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
}
