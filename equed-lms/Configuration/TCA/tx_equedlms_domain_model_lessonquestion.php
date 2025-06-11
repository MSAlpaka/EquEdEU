<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion',
        'label' => 'lesson_quiz',
        'hideTable' => true
    ],
    'columns' => [
        'lesson_quiz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.lesson_quiz',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'question_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.question_text',
            'config' => [
                'type' => 'text'
            ]
        ],
        'question_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.question_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.points',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'order_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.order_number',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquestion.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'lesson_quiz, question_text, question_type, points, order_number, created_at, updated_at, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'lesson_quiz,question_text,question_type,points,order_number,created_at,updated_at,uuid'
    ]
];
