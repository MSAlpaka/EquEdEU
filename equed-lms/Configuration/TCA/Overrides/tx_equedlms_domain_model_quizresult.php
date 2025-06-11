<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_quizresult',
        'label' => 'score',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'hideTable' => true,
        'readOnly' => true,
        'searchFields' => 'score,max_score,mode,lang',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
    ],
    'columns' => [
        'user_course_record' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.user_course_record',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usercourserecord',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'lesson_quiz' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.lesson_quiz',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquiz',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'score' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.score',
            'config' => [
                'type' => 'number',
                'readOnly' => true
            ]
        ],
        'max_score' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.max_score',
            'config' => [
                'type' => 'number',
                'readOnly' => true
            ]
        ],
        'passed' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.passed',
            'config' => [
                'type' => 'check',
                'readOnly' => true
            ]
        ],
        'mode' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.mode',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Web', 'web'],
                    ['App', 'app'],
                    ['Demo', 'demo'],
                    ['Retry', 'retry']
                ],
                'readOnly' => true
            ]
        ],
        'submitted_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:quizresult.submitted_at',
            'config' => [
                'type' => 'datetime',
                'readOnly' => true
            ]
        ],
        'lang' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ]
    ],
    'types' => [
        '0' => [
            'showitem' => 'user_course_record, lesson_quiz, score, max_score, passed, mode, submitted_at, lang'
        ]
    ]
];
