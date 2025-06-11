<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'exam_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.exam_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'criteria' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.criteria',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'required_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.required_score',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'required_percentage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.required_percentage',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.is_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_examtemplate.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, course_program, exam_type, criteria, required_score, required_percentage, is_active, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,course_program,exam_type,criteria,required_score,required_percentage,is_active,uuid'
    ]
];
