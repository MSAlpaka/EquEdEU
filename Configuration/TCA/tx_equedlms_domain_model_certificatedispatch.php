<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'delivery_method' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.delivery_method',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'qr_code_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.qr_code_url',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'pdf' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.pdf',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatedispatch.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, title, fe_user, course_instance, delivery_method, qr_code_url, pdf, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,title,fe_user,course_instance,delivery_method,qr_code_url,pdf,created_at,updated_at'
    ]
];
