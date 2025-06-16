<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport',
        'label' => 'uuid',
        'hideTable' => true
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_course_record' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.instructor',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.certifier',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'reported_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.reported_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'incident_type_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.incident_type_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'severity_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.severity_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Open', 'open'],
                    ['Under Review', 'review'],
                    ['Closed', 'closed'],
                    ['Escalated', 'escalated'],
                ],
                'default' => 'open',
            ]
        ],
        'comment_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.comment_instructor',
            'config' => [
                'type' => 'text'
            ]
        ],
        'comment_service_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.comment_service_center',
            'config' => [
                'type' => 'text'
            ]
        ],
        'comment_certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.comment_certifier',
            'config' => [
                'type' => 'text'
            ]
        ],
        'linked_certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.linked_certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'linked_standard_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.linked_standard_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visible_to_instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.visible_to_instructor',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_to_training_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.visible_to_training_center',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_to_certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.visible_to_certifier',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.is_archived',
            'config' => [
                'type' => 'check'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_incidentreport.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'uuid, user_course_record, course_instance, instructor, certifier, reported_user, incident_type_key, severity_key, status, comment_instructor, comment_service_center, comment_certifier, linked_certificate_number, linked_standard_key, visible_to_instructor, visible_to_training_center, visible_to_certifier, is_archived, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'uuid,user_course_record,course_instance,instructor,certifier,reported_user,incident_type_key,severity_key,status,comment_instructor,comment_service_center,comment_certifier,linked_certificate_number,linked_standard_key,visible_to_instructor,visible_to_training_center,visible_to_certifier,is_archived,created_at,updated_at'
    ]
];
