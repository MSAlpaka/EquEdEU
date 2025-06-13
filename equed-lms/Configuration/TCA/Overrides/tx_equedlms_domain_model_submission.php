<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Submission',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'title,description',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.title',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'rows' => 5,
            ],
        ],
        'file' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.file',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'file',
                ['maxitems' => 10],
                'pdf,jpg,jpeg,png,docx'
            ),
        ],
        'user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'lesson' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.lesson',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_lesson',
                'default' => 0,
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.created_at',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'gpt_analysis_status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.gpt_analysis_status',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'gpt_score' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.gpt_score',
            'config' => [
                'type' => 'input',
                'eval' => 'double2',
            ],
        ],
        'gpt_summary' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.gpt_summary',
            'config' => [
                'type' => 'text',
            ],
        ],
        'gpt_suggestion' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.gpt_suggestion',
            'config' => [
                'type' => 'text',
            ],
        ],
        'gpt_analysis_data' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.gpt_analysis_data',
            'config' => [
                'type' => 'text',
            ],
        ],
        'analyzed_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.analyzed_at',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'text_content' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:submission.text_content',
            'config' => [
                'type' => 'text',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                title, description, file, user, lesson, created_at, uuid, gpt_analysis_status, gpt_score, gpt_summary, gpt_suggestion, gpt_analysis_data, analyzed_at, text_content
            ',
        ],
    ],
];
