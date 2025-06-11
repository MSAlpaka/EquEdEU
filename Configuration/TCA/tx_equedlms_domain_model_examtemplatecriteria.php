<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_override' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.title_override',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'max_points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.max_points',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.is_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.position',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'exam_template' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.exam_template',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplatecriteria.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title_key, title_override, max_points, is_required, position, exam_template, is_archived, created_at, updated_at, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title_key,title_override,max_points,is_required,position,exam_template,is_archived,created_at,updated_at,uuid'
    ]
];
