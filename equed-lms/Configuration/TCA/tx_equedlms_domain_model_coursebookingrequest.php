<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest',
        'label' => 'requested_by',
        'hideTable' => true
    ],
    'columns' => [
        'requested_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.requested_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'preferred_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.preferred_center',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'preferred_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.preferred_instructor',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'preferred_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.preferred_date',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'comments' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.comments',
            'config' => [
                'type' => 'text'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'assigned_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.assigned_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebookingrequest.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'requested_by, course_program, preferred_center, preferred_instructor, preferred_date, comments, status, assigned_instance, created_at, updated_at, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'requested_by,course_program,preferred_center,preferred_instructor,preferred_date,comments,status,assigned_instance,created_at,updated_at,uuid'
    ]
];
