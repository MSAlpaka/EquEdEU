<?php

declare(strict_types=1);

defined('TYPO3') || die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Equed\EquedLms\Controller\Api\ServiceCenterController;

/**
 * Registers the Service Center module under the System main module.
 */
ExtensionUtility::registerModule(
    'Equed.EquedLms',
    'system',
    'servicecenter',
    '',
    [
        ServiceCenterController::class => 'dashboard,manageCases',
    ],
    [
        'access' => 'admin',
        'icon' => 'EXT:equed_lms/Resources/Public/Icons/qms.svg',
        'labels' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_mod_servicecenter.xlf',
        'navigationComponentId' => '',
    ]
);
// EOF
