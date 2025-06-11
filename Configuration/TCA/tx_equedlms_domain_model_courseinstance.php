<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance',
        'label' => 'courseprogram',
        'hideTable' => true
    ],
    'columns' => [
        'courseprogram' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.courseprogram',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'start_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.start_date',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'end_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.end_date',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.instructor',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'location' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.location',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'validation_mode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.validation_mode',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'access_policy' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.access_policy',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.tags',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'metadata' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.metadata',
            'config' => [
                'type' => 'text'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'courseprogram, start_date, end_date, instructor, location, validation_mode, access_policy, tags, metadata'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'courseprogram,start_date,end_date,instructor,location,validation_mode,access_policy,tags,metadata'
    ]
];
