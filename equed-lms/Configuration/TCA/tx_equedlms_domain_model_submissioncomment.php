<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment',
        'label' => 'submission',
        'hideTable' => true
    ],
    'columns' => [
        'submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment.submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'author' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment.author',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment.comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible_for_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment.visible_for_user',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'submission, author, comment, lang, visible_for_user'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'submission,author,comment,lang,visible_for_user'
    ]
];
