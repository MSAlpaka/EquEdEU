<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter',
        'label' => 'name',
        'hideTable' => true
    ],
    'columns' => [
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'center_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.center_id',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.address',
            'config' => [
                'type' => 'text'
            ]
        ],
        'region' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.region',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.country',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'contact_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.contact_email',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'website' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.website',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certified_until' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.certified_until',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Aktiv', 'active'],
                    ['Inaktiv', 'inactive'],
                    ['Gesperrt', 'suspended'],
                ],
                'default' => 'active',
            ]
        ],
        'allowed_programs' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.allowed_programs',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'MM' => 'tx_equedlms_trainingcenter_program_mm',
                'size' => 8,
                'autoSizeMax' => 20,
                'multiple' => 1,
            ]
        ],
        'instructors' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.instructors',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_users',
                'foreign_table_where' => 'AND fe_users.is_instructor = 1',
                'MM' => 'tx_equedlms_trainingcenter_instructor_mm',
                'size' => 8,
                'autoSizeMax' => 20,
                'multiple' => 1,
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenter.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'name, center_id, description, address, region, country, contact_email, phone, website, certified_until, status, allowed_programs, instructors, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'name,center_id,description,address,region,country,contact_email,phone,website,certified_until,status,allowed_programs,instructors,uuid'
    ]
];
