<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.certifier',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'incident_report' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.incident_report',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'finalized_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.finalized_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'title_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'case_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.case_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Violation', \Equed\EquedLms\Enum\QmsCaseType::Violation->value],
                    ['Complaint', \Equed\EquedLms\Enum\QmsCaseType::Complaint->value],
                    ['Audit', \Equed\EquedLms\Enum\QmsCaseType::Audit->value],
                ],
                'default' => \Equed\EquedLms\Enum\QmsCaseType::Violation->value,
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Open', \Equed\EquedLms\Enum\QmsCaseStatus::Open->value],
                    ['In Progress', \Equed\EquedLms\Enum\QmsCaseStatus::InProgress->value],
                    ['Closed', \Equed\EquedLms\Enum\QmsCaseStatus::Closed->value],
                ],
                'default' => \Equed\EquedLms\Enum\QmsCaseStatus::Open->value,
            ]
        ],
        'priority' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.priority',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'violates_standard' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.violates_standard',
            'config' => [
                'type' => 'check'
            ]
        ],
        'standard_reference' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.standard_reference',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'decision' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.decision',
            'config' => [
                'type' => 'text'
            ]
        ],
        'attachment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.attachment',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'visible_to_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.visible_to_instructor',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_to_training_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.visible_to_training_center',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_to_certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.visible_to_certifier',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, user_course_record, course_instance, certifier, incident_report, finalized_by, title, title_key, case_type, status, priority, violates_standard, standard_reference, comment, decision, attachment, visible_to_instructor, visible_to_training_center, visible_to_certifier, is_archived, language, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,user_course_record,course_instance,certifier,incident_report,finalized_by,title,title_key,case_type,status,priority,violates_standard,standard_reference,comment,decision,attachment,visible_to_instructor,visible_to_training_center,visible_to_certifier,is_archived,language,created_at,updated_at'
    ]
];
