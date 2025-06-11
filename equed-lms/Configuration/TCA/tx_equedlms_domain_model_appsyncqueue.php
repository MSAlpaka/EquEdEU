<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue',
        'label' => 'payload_type',
        'hideTable' => true
    ],
    'columns' => [
        'payload_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.payload_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'payload_data' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.payload_data',
            'config' => [
                'type' => 'text'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'attempt_count' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.attempt_count',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'last_attempt_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_appsyncqueue.last_attempt_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'payload_type, payload_data, status, attempt_count, last_attempt_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'payload_type,payload_data,status,attempt_count,last_attempt_at'
    ]
];
