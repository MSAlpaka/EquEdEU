<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'duration_minutes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.duration_minutes',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'module' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.module',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_module'
            ]
        ],
        'sort_order' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.sort_order',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.visible',
            'config' => [
                'type' => 'check'
            ]
        ],
        'materials' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lesson.materials',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, duration_minutes, course_program, module, sort_order, visible, materials'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,duration_minutes,course_program,module,sort_order,visible,materials'
    ]
];
