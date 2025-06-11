<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt',
        'label' => 'user',
        'hideTable' => true
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'exam_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.exam_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'exam_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.exam_date',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_passed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.is_passed',
            'config' => [
                'type' => 'check'
            ]
        ],
        'score_total' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.score_total',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'score_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.score_required',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'score_percentage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.score_percentage',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'grader' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.grader',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'grader_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.grader_comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'attempt_data_json' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.attempt_data_json',
            'config' => [
                'type' => 'text'
            ]
        ],
        'linked_submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.linked_submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'linked_quiz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.linked_quiz',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'reviewed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.reviewed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'allow_retake' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.allow_retake',
            'config' => [
                'type' => 'check'
            ]
        ],
        'retake_reason' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.retake_reason',
            'config' => [
                'type' => 'text'
            ]
        ],
        'grading_template' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.grading_template',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'documents_upload' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.documents_upload',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examattempt.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user, course_instance, exam_type, exam_date, status, is_passed, score_total, score_required, score_percentage, grader, grader_comment, attempt_data_json, linked_submission, linked_quiz, reviewed_at, allow_retake, retake_reason, grading_template, documents_upload, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user,course_instance,exam_type,exam_date,status,is_passed,score_total,score_required,score_percentage,grader,grader_comment,attempt_data_json,linked_submission,linked_quiz,reviewed_at,allow_retake,retake_reason,grading_template,documents_upload,uuid'
    ]
];
