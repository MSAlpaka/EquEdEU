<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'versioningWS' => true,
        'hideTable' => false,
        'languageField' => 'sys_language_uid',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'searchFields' => 'title,simple_explanation,expert_explanation,status',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
    ],
    'columns' => [
        'sys_language_uid' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language'
            ]
        ],
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'frontend_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.frontend_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.title',
            'config' => [
                'type' => 'input',
                'required' => true,
                'size' => 50
            ]
        ],
        'title_key' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'simple_explanation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.simple_explanation',
            'config' => [
                'type' => 'text',
                'required' => true,
                'enableRichtext' => true
            ]
        ],
        'expert_explanation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.expert_explanation',
            'config' => [
                'type' => 'text',
                'required' => true,
                'enableRichtext' => true
            ]
        ],
        'lang' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.lang',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['English', 'en'],
                    ['Deutsch', 'de'],
                    ['Français', 'fr'],
                    ['Español', 'es'],
                    ['Kiswahili', 'sw'],
                    ['EASY', 'easy']
                ],
                'required' => true
            ]
        ],
        'icon_identifier' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.icon_identifier',
            'config' => [
                'type' => 'input'
            ]
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Pending', 'pending'],
                    ['Approved', 'approved'],
                    ['Rejected', 'rejected']
                ],
                'default' => 'pending'
            ]
        ],
        'admin_comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossarysuggestion.admin_comment',
            'config' => [
                'type' => 'text'
            ]
        ]
    ],
    'types' => [
        '0' => [
            'showitem' => 'frontend_user, title, title_key, simple_explanation, expert_explanation, lang, icon_identifier, status, admin_comment'
        ]
    ]
];
