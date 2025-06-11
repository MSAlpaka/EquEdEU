<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility',
        'label' => 'fe_user',
        'hideTable' => true
    ],
    'columns' => [
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'eligibility_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.eligibility_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'source_reference' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.source_reference',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_examiner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.is_examiner',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.is_certifier',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.is_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'approved_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.approved_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'expires_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.expires_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'note' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.note',
            'config' => [
                'type' => 'text'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoreligibility.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'fe_user, course_program, eligibility_type, source_reference, is_examiner, is_certifier, is_active, approved_at, expires_at, note, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'fe_user,course_program,eligibility_type,source_reference,is_examiner,is_certifier,is_active,approved_at,expires_at,note,uuid,created_at,updated_at'
    ]
];
