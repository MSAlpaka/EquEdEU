<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog',
        'label' => 'ip_address',
        'hideTable' => true
    ],
    'columns' => [
        'ip_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.ip_address',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_agent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.user_agent',
            'config' => [
                'type' => 'text'
            ]
        ],
        'event_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.event_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'event_context' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.event_context',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesslog.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'ip_address, user_agent, event_type, event_context, fe_user'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'ip_address,user_agent,event_type,event_context,fe_user'
    ]
];
