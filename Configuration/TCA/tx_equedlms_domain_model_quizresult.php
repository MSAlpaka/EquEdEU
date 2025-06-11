<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult',
        'label' => 'user_course_record',
        'hideTable' => true
    ],
    'columns' => [
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson_quiz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.lesson_quiz',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.score',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'max_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.max_score',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'passed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.passed',
            'config' => [
                'type' => 'check'
            ]
        ],
        'mode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.mode',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'submitted_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.submitted_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user_course_record, lesson_quiz, score, max_score, passed, mode, submitted_at, lang'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user_course_record,lesson_quiz,score,max_score,passed,mode,submitted_at,lang'
    ]
];
