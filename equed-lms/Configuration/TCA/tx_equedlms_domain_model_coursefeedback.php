<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback',
        'label' => 'user_course_record',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'submitted_by_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.submitted_by_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'rating_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.rating_instructor',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'rating_training_location' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.rating_training_location',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'rating_overall' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.rating_overall',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'standard_coverage_confirmed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.standard_coverage_confirmed',
            'config' => [
                'type' => 'check'
            ]
        ],
        'wants_followup_info' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.wants_followup_info',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_visible_to_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.is_visible_to_instructor',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_visible_to_training_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.is_visible_to_training_center',
            'config' => [
                'type' => 'check'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'course_wishes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.course_wishes',
            'config' => [
                'type' => 'text'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Submitted', 'submitted'],
                    ['Reviewed', 'reviewed'],
                ],
                'default' => 'submitted',
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, user_course_record, submitted_by_user, rating_instructor, rating_training_location, rating_overall, standard_coverage_confirmed, wants_followup_info, is_visible_to_instructor, is_visible_to_training_center, language, comment, course_wishes, status, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,user_course_record,submitted_by_user,rating_instructor,rating_training_location,rating_overall,standard_coverage_confirmed,wants_followup_info,is_visible_to_instructor,is_visible_to_training_center,language,comment,course_wishes,status,created_at,updated_at'
    ]
];
