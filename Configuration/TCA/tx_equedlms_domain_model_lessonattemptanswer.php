<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer',
        'label' => 'lesson_attempt',
        'hideTable' => true
    ],
    'columns' => [
        'lesson_attempt' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.lesson_attempt',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson_question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.lesson_question',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'question_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.question_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'answer_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.answer_text',
            'config' => [
                'type' => 'text'
            ]
        ],
        'answer_option_ids' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.answer_option_ids',
            'config' => [
                'type' => 'text'
            ]
        ],
        'file_upload' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.file_upload',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_correct' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.is_correct',
            'config' => [
                'type' => 'check'
            ]
        ],
        'points_awarded' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.points_awarded',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'max_points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.max_points',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'requires_review' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.requires_review',
            'config' => [
                'type' => 'check'
            ]
        ],
        'reviewed_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.reviewed_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.instructor_comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'qms_flagged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.qms_flagged',
            'config' => [
                'type' => 'check'
            ]
        ],
        'evaluation_notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.evaluation_notes',
            'config' => [
                'type' => 'text'
            ]
        ],
        'time_spent_sec' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.time_spent_sec',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'version_hash' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.version_hash',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'answer_uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattemptanswer.answer_uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'lesson_attempt, lesson_question, question_type, answer_text, answer_option_ids, file_upload, is_correct, points_awarded, max_points, requires_review, reviewed_by, instructor_comment, status, qms_flagged, evaluation_notes, time_spent_sec, version_hash, answer_uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'lesson_attempt,lesson_question,question_type,answer_text,answer_option_ids,file_upload,is_correct,points_awarded,max_points,requires_review,reviewed_by,instructor_comment,status,qms_flagged,evaluation_notes,time_spent_sec,version_hash,answer_uuid'
    ]
];
