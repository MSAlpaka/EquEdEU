<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'description_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.description_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'available_from' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.available_from',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.hidden',
            'config' => [
                'type' => 'check'
            ]
        ],
        'course_programs' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.course_programs',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'MM' => 'tx_equedlms_coursebundle_courseprogram_mm',
                'size' => 8,
                'autoSizeMax' => 20,
                'multiple' => 1
            ]
        ],
        'price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.price',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'discount_percentage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.discount_percentage',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.is_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_visible' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.is_visible',
            'config' => [
                'type' => 'check'
            ]
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.slug',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.image',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'recommended_after' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.recommended_after',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursebundle.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, title_key, description, description_key, available_from, hidden, course_programs, price, discount_percentage, is_active, is_visible, slug, image, recommended_after, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,title_key,description,description_key,available_from,hidden,course_programs,price,discount_percentage,is_active,is_visible,slug,image,recommended_after,uuid,created_at,updated_at'
    ]
];
