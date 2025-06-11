<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog',
        'label' => 'action_type',
        'hideTable' => true
    ],
    'columns' => [
        'action_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.action_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'target_table' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.target_table',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'target_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.target_uid',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'context_data' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.context_data',
            'config' => [
                'type' => 'text'
            ]
        ],
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_auditlog.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'action_type, target_table, target_uid, context_data, fe_user'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'action_type,target_table,target_uid,context_data,fe_user'
    ]
];
