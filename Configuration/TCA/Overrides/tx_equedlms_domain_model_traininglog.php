<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog',
        'label' => 'event_type',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'readOnly' => true,
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
    ],
    'columns' => [
        'user_course_record' => [
            'label' => 'User Course Record',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usercourserecord',
                'size' => 1,
                'maxitems' => 1,
                'readOnly' => true
            ]
        ],
        'event_type' => [
            'label' => 'Event Type',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ],
        'event_key' => [
            'label' => 'Event Key',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ],
        'details' => [
            'label' => 'Details',
            'config' => [
                'type' => 'text',
                'readOnly' => true
            ]
        ],
        'lang' => [
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'readOnly' => true
            ]
        ],
        'is_archived' => [
            'label' => 'Archived',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'user_course_record, event_type, event_key, details, lang, is_archived']
    ]
];
