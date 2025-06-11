<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'quiz_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.quiz_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'pass_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.pass_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'pass_percentage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.pass_percentage',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'max_attempts' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.max_attempts',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'questions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.questions',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'randomize_questions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.randomize_questions',
            'config' => [
                'type' => 'check'
            ]
        ],
        'shuffle_answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.shuffle_answers',
            'config' => [
                'type' => 'check'
            ]
        ],
        'show_feedback_per_question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.show_feedback_per_question',
            'config' => [
                'type' => 'check'
            ]
        ],
        'time_limit_sec' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.time_limit_sec',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'allow_back_navigation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.allow_back_navigation',
            'config' => [
                'type' => 'check'
            ]
        ],
        'external_grading_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.external_grading_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'feedback_success' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.feedback_success',
            'config' => [
                'type' => 'text'
            ]
        ],
        'feedback_fail' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.feedback_fail',
            'config' => [
                'type' => 'text'
            ]
        ],
        'visible_in_overview' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.visible_in_overview',
            'config' => [
                'type' => 'check'
            ]
        ],
        'relevant_for_progress' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.relevant_for_progress',
            'config' => [
                'type' => 'check'
            ]
        ],
        'relevant_for_certification' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonquiz.relevant_for_certification',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, lesson, description, quiz_type, pass_required, pass_percentage, max_attempts, questions, randomize_questions, shuffle_answers, show_feedback_per_question, time_limit_sec, allow_back_navigation, external_grading_required, feedback_success, feedback_fail, visible_in_overview, relevant_for_progress, relevant_for_certification'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,lesson,description,quiz_type,pass_required,pass_percentage,max_attempts,questions,randomize_questions,shuffle_answers,show_feedback_per_question,time_limit_sec,allow_back_navigation,external_grading_required,feedback_success,feedback_fail,visible_in_overview,relevant_for_progress,relevant_for_certification'
    ]
];
