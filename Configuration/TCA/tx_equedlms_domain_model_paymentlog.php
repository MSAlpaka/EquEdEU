<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog',
        'label' => 'user',
        'hideTable' => true
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'amount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.amount',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'payment_method' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.payment_method',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'transaction_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.transaction_id',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_paymentlog.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user, amount, payment_method, transaction_id, status, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user,amount,payment_method,transaction_id,status,uuid,created_at,updated_at'
    ]
];
