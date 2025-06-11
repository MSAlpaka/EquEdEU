<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken',
        'label' => 'token',
        'hideTable' => true
    ],
    'columns' => [
        'token' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.token',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.label',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'expires_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.expires_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'revoked' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_apitoken.revoked',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'token, label, expires_at, revoked'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'token,label,expires_at,revoked'
    ]
];
