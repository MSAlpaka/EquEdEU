<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion',
        'label' => 'practice_test',
        'hideTable' => true
    ],
    'columns' => [
        'practice_test' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.practice_test',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'question_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.question_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'question_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.question_text',
            'config' => [
                'type' => 'text'
            ]
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.image',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.answers',
            'config' => [
                'type' => 'text'
            ]
        ],
        'correct_answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.correct_answers',
            'config' => [
                'type' => 'text'
            ]
        ],
        'explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.explanation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.position',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'expected_answer_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.expected_answer_text',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'generated_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.generated_by',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'gpt_version' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.gpt_version',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'glossary_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.glossary_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'difficulty' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.difficulty',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_practicequestion.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'practice_test, question_type, question_text, image, answers, correct_answers, explanation, position, expected_answer_text, generated_by, gpt_version, glossary_key, difficulty, lang, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'practice_test,question_type,question_text,image,answers,correct_answers,explanation,position,expected_answer_text,generated_by,gpt_version,glossary_key,difficulty,lang,uuid,created_at,updated_at'
    ]
];
