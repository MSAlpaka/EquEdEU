<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage',
        'label' => 'lesson',
        'hideTable' => true
    ],
    'columns' => [
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'content' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage.content',
            'config' => [
                'type' => 'text'
            ]
        ],
        'icon_identifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage.icon_identifier',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visibility_condition' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage.visibility_condition',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'lesson, title_key, content, icon_identifier, visibility_condition'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'lesson,title_key,content,icon_identifier,visibility_condition'
    ]
];
