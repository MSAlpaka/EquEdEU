<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_accesslog',
    [
        'ip_address' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.ip_address',
            'config'  => [
                'type'    => 'input',
                'size'    => 30,
                'eval'    => 'trim,required,ip',
                'default' => '',
            ],
        ],
        'user_agent' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.user_agent',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 2,
                'eval' => 'trim',
            ],
        ],
        'event_type' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.event_type',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim,required',
                'size' => 40,
            ],
        ],
        'event_context' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.event_context',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => 60,
            ],
        ],
        'fe_user' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems'      => 0,
                'maxitems'      => 1,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_accesslog',
    'ip_address, user_agent, event_type, event_context, fe_user',
    '',
    'after:crdate'
);
