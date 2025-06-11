<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_auditlog',
    [
        'action_type' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.action_type',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    ['Create', 'create'],
                    ['Update', 'update'],
                    ['Delete', 'delete'],
                    ['Login', 'login'],
                    ['Logout', 'logout'],
                ],
                'default'    => 'create',
            ],
        ],
        'target_table' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.target_table',
            'config'  => [
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim,required',
            ],
        ],
        'target_uid' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.target_uid',
            'config'  => [
                'type'    => 'input',
                'eval'    => 'int',
                'default' => 0,
            ],
        ],
        'context_data' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.context_data',
            'config'  => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 6,
                'eval' => 'trim',
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
    'tx_equedlms_domain_model_auditlog',
    'action_type, target_table, target_uid, context_data, fe_user',
    '',
    'after:crdate'
);
