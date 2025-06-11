<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_appsyncqueue',
    [
        'payload_type' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.payload_type',
            'config'  => [
                'type'       => 'input',
                'size'       => 40,
                'eval'       => 'trim,required',
            ],
        ],
        'payload_data' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.payload_data',
            'config'  => [
                'type'       => 'text',
                'cols'       => 60,
                'rows'       => 6,
                'eval'       => 'trim',
            ],
        ],
        'status' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.status',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    ['pending', 'pending'],
                    ['processing', 'processing'],
                    ['success', 'success'],
                    ['failed', 'failed'],
                ],
                'default'    => 'pending',
            ],
        ],
        'attempt_count' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.attempt_count',
            'config'  => [
                'type'    => 'input',
                'eval'    => 'int',
                'default' => 0,
            ],
        ],
        'last_attempt_at' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.last_attempt_at',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'datetime',
                'default'    => null,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_appsyncqueue',
    'payload_type, payload_data, status, attempt_count, last_attempt_at',
    '',
    'after:crdate'
);
