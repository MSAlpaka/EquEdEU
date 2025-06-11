<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback',
        'label' => 'frontend_user',
        'hideTable' => true
    ],
    'columns' => [
        'frontend_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.frontend_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.instructor_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'user_submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.user_submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson_attempt' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.lesson_attempt',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'feedback_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.feedback_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'rating' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.rating',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'recommendation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.recommendation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'attachment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.attachment',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'submitted_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.submitted_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible_to_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.visible_to_user',
            'config' => [
                'type' => 'check'
            ]
        ],
        'qms_flagged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.qms_flagged',
            'config' => [
                'type' => 'check'
            ]
        ],
        'qms_case' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.qms_case',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'feedback_uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.feedback_uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'revision_of' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.revision_of',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_final' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.is_final',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_automated' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructorfeedback.is_automated',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'frontend_user, instructor_user, course_instance, lesson, user_submission, lesson_attempt, feedback_type, title, comment, rating, recommendation, attachment, submitted_at, visible_to_user, qms_flagged, qms_case, feedback_uuid, revision_of, language, is_final, is_automated'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'frontend_user,instructor_user,course_instance,lesson,user_submission,lesson_attempt,feedback_type,title,comment,rating,recommendation,attachment,submitted_at,visible_to_user,qms_flagged,qms_case,feedback_uuid,revision_of,language,is_final,is_automated'
    ]
];
