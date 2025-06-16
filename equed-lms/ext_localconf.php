<?php
declare(strict_types=1);

use Equed\EquedLms\Controller\CourseController;
use Equed\EquedLms\Controller\Api\DashboardApiController;
use Equed\EquedLms\Controller\GlossaryController;
use Symfony\Component\Dotenv\Dotenv;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

// Load environment variables if available
if (file_exists(Environment::getProjectPath() . '/.env')) {
    (new Dotenv())->usePutenv()->bootEnv(Environment::getProjectPath() . '/.env');
}

// Register plugins
ExtensionUtility::configurePlugin(
    'EquedLms',
    'Course',
    [CourseController::class => 'list, show'],
    [CourseController::class => 'create, update, delete']
);

ExtensionUtility::configurePlugin(
    'EquedLms',
    'Glossary',
    [GlossaryController::class => 'list, show'],
    []
);

ExtensionUtility::configurePlugin(
    'EquedLms',
    'Dashboard',
    [DashboardApiController::class => 'show'],
    []
);

// Event listeners

// Caching framework registration
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['equed_lms_api'] = [
    'backend' => \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class,
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['equed_lms_course'] = [
    'backend' => \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class,
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class
];

// Middleware activation
$GLOBALS['TYPO3_CONF_VARS']['FE']['middleware']['equed/authentication'] = [
    'target' => \Equed\EquedLms\Middleware\ApiAuthenticationMiddleware::class,
    'after' => ['typo3/cms-frontend/authentication']
];

// Scheduler example
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Equed\EquedLms\Task\CertificateRenewalReminderTask::class] = [
    'extension' => 'equed_lms',
    'title' => 'LLL:EXT:equed-lms/Resources/Private/Language/locallang.xlf:task.certificateRenewalReminder.title',
    'description' => 'LLL:EXT:equed-lms/Resources/Private/Language/locallang.xlf:task.certificateRenewalReminder.description',
];
