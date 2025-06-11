<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_apitoken',
    [
        'token' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.token',
            'config'  => [
                'type'    => 'input',
                'size'    => 60,
                'eval'    => 'trim,required',
                'readOnly' => true,
            ],
        ],
        'label' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.label',
            'config'  => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
            ],
        ],
        'expires_at' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.expires_at',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'datetime',
                'default'    => null,
            ],
        ],
        'revoked' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.disable',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 0,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_apitoken',
    'label, token, expires_at, revoked',
    '',
    'after:crdate'
);
