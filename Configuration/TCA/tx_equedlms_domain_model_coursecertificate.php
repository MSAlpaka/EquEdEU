<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certificate_template' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.certificate_template',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certificate_dispatch' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.certificate_dispatch',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.badge_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_public' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.is_public',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_badge_relevant' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.is_badge_relevant',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_auto_generated' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.is_auto_generated',
            'config' => [
                'type' => 'check'
            ]
        ],
        'issued_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.issued_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursecertificate.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, user_course_record, certificate_template, certificate_dispatch, certificate_number, language, badge_level, is_public, is_archived, is_badge_relevant, is_auto_generated, issued_at, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,user_course_record,certificate_template,certificate_dispatch,certificate_number,language,badge_level,is_public,is_archived,is_badge_relevant,is_auto_generated,issued_at,created_at,updated_at'
    ]
];
