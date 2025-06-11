<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'label_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.label_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.description_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'criteria' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.criteria',
            'config' => [
                'type' => 'text'
            ]
        ],
        'default_lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.default_lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badgedefinition.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, level, code, label_key, description_key, criteria, default_lang, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,level,code,label_key,description_key,criteria,default_lang,created_at,updated_at'
    ]
];
