<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'frontend_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.frontend_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'badge_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.badge_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.badge_code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.badge_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'description_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.description_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'awarded_by_system' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.awarded_by_system',
            'config' => [
                'type' => 'check'
            ]
        ],
        'awarded_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.awarded_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'awarded_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.awarded_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'valid_until' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.valid_until',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgeaward.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, frontend_user, user_course_record, badge_type, badge_code, badge_level, description_key, lang, awarded_by_system, awarded_by, awarded_at, valid_until, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,frontend_user,user_course_record,badge_type,badge_code,badge_level,description_key,lang,awarded_by_system,awarded_by,awarded_at,valid_until,created_at,updated_at'
    ]
];
