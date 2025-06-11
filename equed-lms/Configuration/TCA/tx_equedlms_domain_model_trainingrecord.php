<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord',
        'label' => 'user_course_record',
        'hideTable' => true
    ],
    'columns' => [
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'training_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.training_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'duration_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.duration_hours',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.date',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'proof_document' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.proof_document',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_validated' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.is_validated',
            'config' => [
                'type' => 'check'
            ]
        ],
        'validated_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.validated_by',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'final_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.final_score',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_issued' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.certificate_issued',
            'config' => [
                'type' => 'check'
            ]
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_issued_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.certificate_issued_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'gpt_evaluation_data' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.gpt_evaluation_data',
            'config' => [
                'type' => 'text'
            ]
        ],
        'feedback_received' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord.feedback_received',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user_course_record, training_type, title, description, duration_hours, date, proof_document, is_validated, validated_by, lang, is_archived, final_score, certificate_issued, certificate_number, certificate_issued_at, gpt_evaluation_data, feedback_received'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user_course_record,training_type,title,description,duration_hours,date,proof_document,is_validated,validated_by,lang,is_archived,final_score,certificate_issued,certificate_number,certificate_issued_at,gpt_evaluation_data,feedback_received'
    ]
];
