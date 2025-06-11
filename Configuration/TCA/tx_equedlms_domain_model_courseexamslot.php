<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'examiner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.examiner',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'start_date_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.start_date_time',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'end_date_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.end_date_time',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'location' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.location',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'capacity' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.capacity',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'registered_count' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.registered_count',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_cancelled' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.is_cancelled',
            'config' => [
                'type' => 'check'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseexamslot.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, course_instance, examiner, start_date_time, end_date_time, location, capacity, registered_count, is_cancelled, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,course_instance,examiner,start_date_time,end_date_time,location,capacity,registered_count,is_cancelled,created_at,updated_at'
    ]
];
