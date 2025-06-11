<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog',
        'label' => 'user_course_record',
        'hideTable' => true
    ],
    'columns' => [
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'event_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.event_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'event_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.event_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'details' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.details',
            'config' => [
                'type' => 'text'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_traininglog.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user_course_record, event_type, event_key, details, lang, is_archived'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user_course_record,event_type,event_key,details,lang,is_archived'
    ]
];
