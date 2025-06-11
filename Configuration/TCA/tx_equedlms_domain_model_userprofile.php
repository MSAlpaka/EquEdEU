<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'docu_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.docu_level',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'docu_level_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.docu_level_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'total_practice_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.total_practice_hours',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'completed_specialties' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.completed_specialties',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'recognition_award' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.recognition_award',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'recognition_award_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.recognition_award_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.badge_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'badge_level_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.badge_level_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'profile_status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.profile_status',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'profile_status_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.profile_status_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_visible_in_search' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.is_visible_in_search',
            'config' => [
                'type' => 'check'
            ]
        ],
        'has_pro_access' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.has_pro_access',
            'config' => [
                'type' => 'check'
            ]
        ],
        'display_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.display_name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.country',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.is_instructor',
            'config' => [
                'type' => 'check'
            ]
        ],
        'onboarding_complete' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.onboarding_complete',
            'config' => [
                'type' => 'check'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'last_login_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.last_login_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprofile.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, user, docu_level, docu_level_key, total_practice_hours, completed_specialties, recognition_award, recognition_award_key, badge_level, badge_level_key, profile_status, profile_status_key, is_visible_in_search, has_pro_access, display_name, country, is_instructor, onboarding_complete, language, last_login_at, is_archived, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,user,docu_level,docu_level_key,total_practice_hours,completed_specialties,recognition_award,recognition_award_key,badge_level,badge_level_key,profile_status,profile_status_key,is_visible_in_search,has_pro_access,display_name,country,is_instructor,onboarding_complete,language,last_login_at,is_archived,created_at,updated_at'
    ]
];
