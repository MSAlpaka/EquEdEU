<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Equed\EquedCore\Hooks\CertificationHook;
use Equed\EquedCore\Security\JwtLoginService;

// Register processDatamap hook for certification events
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][CertificationHook::class] = CertificationHook::class;

// Register JWT authentication entry point
$GLOBALS['TYPO3_CONF_VARS']['FE']['loginProviders'][1433416747] = [
    'provider' => JwtLoginService::class,
    'label' => 'JWT Login',
];

