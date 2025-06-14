<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'courseprogram' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.courseprogram',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'learning_path' => [
            'exclude' => true,
            'label' => 'Learning Path',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'start_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.start_date',
            'config' => [
                'type' => 'input',
                'eval' => 'date'
            ]
        ],
        'location' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.location',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, courseprogram, learning_path, start_date, location'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,courseprogram,learning_path,start_date,location'
    ]
];
