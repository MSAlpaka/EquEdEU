<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry',
        'label' => 'user',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'hideTable' => false,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'searchFields' => 'requested_topics,open_feedback',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'columns' => [
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'size' => 1,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'user' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'instructor_feedback' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.instructor_feedback',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'course_standard_met' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.course_standard_met',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'wants_more_courses' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.wants_more_courses',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'requested_topics' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.requested_topics',
            'config' => [
                'type' => 'text',
                'enableRichtext' => false,
                'cols' => 40,
                'rows' => 3,
                'default' => '',
            ],
        ],
        'open_feedback' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.open_feedback',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 5,
                'default' => '',
            ],
        ],
        'instructor_rating' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.instructor_rating',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'location_rating' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.location_rating',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'eligible_future_courses' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.eligible_future_courses',
            'config' => [
                'type' => 'text',
                'enableRichtext' => false,
                'cols' => 40,
                'rows' => 2,
                'default' => '',
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.created_at',
            'config' => [
                'type' => 'datetime',
                'readOnly' => true,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                course_instance, user, instructor_feedback, course_standard_met, wants_more_courses,
                requested_topics, open_feedback,
                instructor_rating, location_rating,
                eligible_future_courses, created_at
            ',
        ],
    ],
];
