<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm',
        'label' => 'sys_language_uid',
        'hideTable' => true
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.sys_language_uid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.hidden',
            'config' => [
                'type' => 'check'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'simple_explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.simple_explanation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'expert_explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.expert_explanation',
            'config' => [
                'type' => 'text'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'icon_identifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.icon_identifier',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryterm.visible',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'sys_language_uid, hidden, title, title_key, simple_explanation, expert_explanation, lang, icon_identifier, visible'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid,hidden,title,title_key,simple_explanation,expert_explanation,lang,icon_identifier,visible'
    ]
];
