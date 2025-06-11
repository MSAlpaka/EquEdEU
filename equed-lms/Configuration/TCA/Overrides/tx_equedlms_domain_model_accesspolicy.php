<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_accesspolicy',
    [
        'policy_key' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy.policy_key',
            'config'  => [
                'type'    => 'input',
                'size'    => 40,
                'eval'    => 'trim,required,alphanum_x',
                'default' => '',
            ],
        ],
        'description' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy.description',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 4,
                'eval' => 'trim',
            ],
        ],
        'enabled' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 1,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_accesspolicy',
    'policy_key, description, enabled',
    '',
    'after:title'
);
