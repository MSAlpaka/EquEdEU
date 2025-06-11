<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissioncomment',
        'label' => 'comment',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'readOnly' => true,
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
    ],
    'columns' => [
        'submission' => [
            'label' => 'Submission',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usersubmission',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'author' => [
            'label' => 'Author',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'comment' => [
            'label' => 'Comment',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true
            ]
        ],
        'lang' => [
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible_for_user' => [
            'label' => 'Visible for User',
            'config' => [
                'type' => 'check',
                'default' => 1
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'submission, author, comment, lang, visible_for_user']
    ]
];
