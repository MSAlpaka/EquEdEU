<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm',
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
        'searchFields' => 'title,simple_explanation,expert_explanation',
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
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.title',
            'config' => [
                'type' => 'input',
                'required' => true,
                'size' => 50
            ]
        ],
        'title_key' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'simple_explanation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.simple_explanation',
            'config' => [
                'type' => 'text',
                'required' => true,
                'enableRichtext' => true
            ]
        ],
        'expert_explanation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.expert_explanation',
            'config' => [
                'type' => 'text',
                'required' => true,
                'enableRichtext' => true
            ]
        ],
        'lang' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.lang',
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
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:glossaryterm.icon_identifier',
            'config' => [
                'type' => 'input'
            ]
        ],
        'visible' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'default' => 1
            ]
        ]
    ],
    'types' => [
        '0' => [
            'showitem' => 'title, title_key, simple_explanation, expert_explanation, lang, icon_identifier, visible'
        ]
    ]
];
