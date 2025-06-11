<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption',
        'label' => 'lesson_question',
        'hideTable' => true
    ],
    'columns' => [
        'lesson_question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.lesson_question',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'sort_order' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.sort_order',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'answer_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.answer_text',
            'config' => [
                'type' => 'text'
            ]
        ],
        'is_correct' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.is_correct',
            'config' => [
                'type' => 'check'
            ]
        ],
        'feedback_if_selected' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.feedback_if_selected',
            'config' => [
                'type' => 'text'
            ]
        ],
        'feedback_if_not_selected' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.feedback_if_not_selected',
            'config' => [
                'type' => 'text'
            ]
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonansweroption.media',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'lesson_question, sort_order, answer_text, is_correct, feedback_if_selected, feedback_if_not_selected, media'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'lesson_question,sort_order,answer_text,is_correct,feedback_if_selected,feedback_if_not_selected,media'
    ]
];
