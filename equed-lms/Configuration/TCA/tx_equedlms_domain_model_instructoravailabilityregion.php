<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion',
        'label' => 'fe_user',
        'hideTable' => true
    ],
    'columns' => [
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'region_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.region_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'region_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.region_value',
            'config' => [
                'type' => 'text'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'priority' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.priority',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'note' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.note',
            'config' => [
                'type' => 'text'
            ]
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.is_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_instructoravailabilityregion.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'fe_user, region_type, region_value, course_program, priority, note, is_active, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'fe_user,region_type,region_value,course_program,priority,note,is_active,uuid,created_at,updated_at'
    ]
];
