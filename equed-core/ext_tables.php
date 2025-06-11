<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Allow domain tables on standard pages
ExtensionManagementUtility::allowTableOnStandardPages('tx_equedcore_language');
ExtensionManagementUtility::allowTableOnStandardPages('tx_equedcore_user_meta');

// Load TCA overrides for fe_users
if (is_file(__DIR__ . '/Configuration/TCA/Overrides/fe_users.php')) {
    require __DIR__ . '/Configuration/TCA/Overrides/fe_users.php';
}
