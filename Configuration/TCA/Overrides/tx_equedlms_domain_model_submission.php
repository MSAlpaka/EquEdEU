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
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                title, description, file, user, lesson, created_at
            ',
        ],
    ],
];
