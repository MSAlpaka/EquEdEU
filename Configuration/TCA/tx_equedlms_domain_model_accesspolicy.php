<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy',
        'label' => 'policy_key',
        'hideTable' => true
    ],
    'columns' => [
        'policy_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy.policy_key',
            'config' => [
                'type' => 'input',
                'eval' => 'float'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'enabled' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_accesspolicy.enabled',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'policy_key, description, enabled'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'policy_key,description,enabled'
    ]
];
