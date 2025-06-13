<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'file' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.file',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.lesson',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_lesson',
                'default' => 0,
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'gpt_analysis_status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.gpt_analysis_status',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'gpt_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.gpt_score',
            'config' => [
                'type' => 'input',
                'eval' => 'double2'
            ]
        ],
        'gpt_summary' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.gpt_summary',
            'config' => [
                'type' => 'text'
            ]
        ],
        'gpt_suggestion' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.gpt_suggestion',
            'config' => [
                'type' => 'text'
            ]
        ],
        'gpt_analysis_data' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.gpt_analysis_data',
            'config' => [
                'type' => 'text'
            ]
        ],
        'analyzed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.analyzed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ]
        ],
        'text_content' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submission.text_content',
            'config' => [
                'type' => 'text'
            ]
        ],
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, file, user, lesson, created_at, uuid, gpt_analysis_status, gpt_score, gpt_summary, gpt_suggestion, gpt_analysis_data, analyzed_at, text_content'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,file,user,lesson,created_at,uuid,gpt_analysis_status,gpt_score,gpt_summary,gpt_suggestion,gpt_analysis_data,analyzed_at,text_content'
    ]
];
