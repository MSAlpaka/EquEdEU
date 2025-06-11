<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge',
        'label' => 'user',
        'hideTable' => true
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'badge_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.badge_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'awarded_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.awarded_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'issuer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.issuer',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_public' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.is_public',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_in_profile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.visible_in_profile',
            'config' => [
                'type' => 'check'
            ]
        ],
        'source_data' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.source_data',
            'config' => [
                'type' => 'text'
            ]
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.image',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.badge_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'expires_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.expires_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'renewal_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.renewal_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_userbadge.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user, badge_type, title, description, awarded_at, issuer, is_public, visible_in_profile, source_data, image, badge_level, expires_at, renewal_required, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user,badge_type,title,description,awarded_at,issuer,is_public,visible_in_profile,source_data,image,badge_level,expires_at,renewal_required,uuid'
    ]
];
