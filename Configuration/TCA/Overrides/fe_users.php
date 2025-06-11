<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$additionalColumns = [
    'instructor_level' => [
        'exclude' => true,
        'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:fe_users.instructor_level',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['-', 'none'],
                ['Assistant', 'assistant'],
                ['Instructor', 'instructor'],
                ['Trainer', 'trainer'],
            ],
            'default' => 'none',
        ],
    ],
    'tx_equedcore_2fa_secret' => [
        'exclude' => true,
        'label' => '2FA Secret',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ],
    'tx_equedcore_2fa_enabled' => [
        'exclude' => true,
        'label' => '2FA Enabled',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('fe_users', $additionalColumns);
ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'instructor_level', '', 'after:email');
ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_equedcore_2fa_enabled,tx_equedcore_2fa_secret', '', 'after:password');
