<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonfeedback',
        'label' => 'user_course_record',
        'hideTable' => true
    ],
    'columns' => [
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonfeedback.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'text_feedback' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonfeedback.text_feedback',
            'config' => [
                'type' => 'text'
            ]
        ],
        'course_wish' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonfeedback.course_wish',
            'config' => [
                'type' => 'text'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user_course_record, text_feedback, course_wish'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user_course_record,text_feedback,course_wish'
    ]
];
