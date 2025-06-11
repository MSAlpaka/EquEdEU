<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry',
        'label' => 'course_instance',
        'hideTable' => true
    ],
    'columns' => [
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor_feedback' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.instructor_feedback',
            'config' => [
                'type' => 'check'
            ]
        ],
        'course_standard_met' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.course_standard_met',
            'config' => [
                'type' => 'check'
            ]
        ],
        'wants_more_courses' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.wants_more_courses',
            'config' => [
                'type' => 'check'
            ]
        ],
        'requested_topics' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.requested_topics',
            'config' => [
                'type' => 'text'
            ]
        ],
        'open_feedback' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.open_feedback',
            'config' => [
                'type' => 'text'
            ]
        ],
        'instructor_rating' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.instructor_rating',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'location_rating' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.location_rating',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'eligible_future_courses' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.eligible_future_courses',
            'config' => [
                'type' => 'text'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_feedbackentry.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'course_instance, user, instructor_feedback, course_standard_met, wants_more_courses, requested_topics, open_feedback, instructor_rating, location_rating, eligible_future_courses, created_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'course_instance,user,instructor_feedback,course_standard_met,wants_more_courses,requested_topics,open_feedback,instructor_rating,location_rating,eligible_future_courses,created_at'
    ]
];
