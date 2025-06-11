<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord',
        'label' => 'user',
        'hideTable' => true
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson_page' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.lesson_page',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'completed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.completed',
            'config' => [
                'type' => 'check'
            ]
        ],
        'completed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.completed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'progress_percent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.progress_percent',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'last_accessed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.last_accessed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'attempt_count' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.attempt_count',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'time_spent_seconds' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.time_spent_seconds',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'feedback_submitted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.feedback_submitted',
            'config' => [
                'type' => 'check'
            ]
        ],
        'notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.notes',
            'config' => [
                'type' => 'text'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userprogressrecord.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user, course_instance, lesson, lesson_page, completed, completed_at, progress_percent, last_accessed_at, attempt_count, time_spent_seconds, feedback_submitted, notes, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user,course_instance,lesson,lesson_page,completed,completed_at,progress_percent,last_accessed_at,attempt_count,time_spent_seconds,feedback_submitted,notes,uuid,created_at,updated_at'
    ]
];
