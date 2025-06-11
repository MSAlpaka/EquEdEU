<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion',
        'label' => 'sys_language_uid',
        'hideTable' => true
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.sys_language_uid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.hidden',
            'config' => [
                'type' => 'check'
            ]
        ],
        'frontend_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.frontend_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'simple_explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.simple_explanation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'expert_explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.expert_explanation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'icon_identifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.icon_identifier',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'admin_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossarysuggestion.admin_comment',
            'config' => [
                'type' => 'text'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'sys_language_uid, hidden, frontend_user, title, title_key, simple_explanation, expert_explanation, lang, icon_identifier, status, admin_comment'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid,hidden,frontend_user,title,title_key,simple_explanation,expert_explanation,lang,icon_identifier,status,admin_comment'
    ]
];
