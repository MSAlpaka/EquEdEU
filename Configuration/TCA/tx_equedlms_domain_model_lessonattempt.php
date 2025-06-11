<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt',
        'label' => 'lesson_quiz',
        'hideTable' => true
    ],
    'columns' => [
        'lesson_quiz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.lesson_quiz',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'frontend_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.frontend_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'attempt_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.attempt_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'score_percent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.score_percent',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'score_raw' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.score_raw',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'max_points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.max_points',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'passed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.passed',
            'config' => [
                'type' => 'check'
            ]
        ],
        'start_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.start_time',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'end_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.end_time',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'duration_sec' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.duration_sec',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'attempt_status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.attempt_status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'graded_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.graded_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'feedback' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.feedback',
            'config' => [
                'type' => 'text'
            ]
        ],
        'qms_flagged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.qms_flagged',
            'config' => [
                'type' => 'check'
            ]
        ],
        'answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonattempt.answers',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'lesson_quiz, frontend_user, attempt_number, score_percent, score_raw, max_points, passed, start_time, end_time, duration_sec, attempt_status, graded_by, feedback, qms_flagged, answers'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'lesson_quiz,frontend_user,attempt_number,score_percent,score_raw,max_points,passed,start_time,end_time,duration_sec,attempt_status,graded_by,feedback,qms_flagged,answers'
    ]
];
