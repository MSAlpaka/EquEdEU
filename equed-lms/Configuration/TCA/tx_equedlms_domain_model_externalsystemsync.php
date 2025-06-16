<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync',
        'label' => 'system_name',
        'hideTable' => true
    ],
    'columns' => [
        'system_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.system_name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'integration_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.integration_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'endpoint_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.endpoint_url',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'auth_token' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.auth_token',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'sync_scope' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.sync_scope',
            'config' => [
                'type' => 'text'
            ]
        ],
        'last_synced_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.last_synced_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'sync_status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.sync_status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['OK', 'ok'],
                    ['Failed', 'failed'],
                    ['Pending', 'pending'],
                ],
                'default' => 'pending',
            ]
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.is_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'log' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.log',
            'config' => [
                'type' => 'text'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_externalsystemsync.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'system_name, integration_type, endpoint_url, auth_token, sync_scope, last_synced_at, sync_status, is_active, log, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'system_name,integration_type,endpoint_url,auth_token,sync_scope,last_synced_at,sync_status,is_active,log,uuid,created_at,updated_at'
    ]
];
