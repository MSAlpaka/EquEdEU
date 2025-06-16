<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram',
        'label' => 'training_center',
        'hideTable' => true
    ],
    'columns' => [
        'training_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.training_center',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'description_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.description_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_icon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.badge_icon',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'requires_external_examiner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.requires_external_examiner',
            'config' => [
                'type' => 'check'
            ]
        ],
        'certifier_must_validate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.certifier_must_validate',
            'config' => [
                'type' => 'check'
            ]
        ],
        'recertification_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.recertification_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'recertification_interval_years' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.recertification_interval_years',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'visible_in_catalog' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.visible_in_catalog',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, title_key, description, description_key, training_center, badge_icon, requires_external_examiner, certifier_must_validate, recertification_required, recertification_interval_years, visible_in_catalog'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,title_key,description,description_key,training_center,badge_icon,requires_external_examiner,certifier_must_validate,recertification_required,recertification_interval_years,visible_in_catalog'
    ]
];
