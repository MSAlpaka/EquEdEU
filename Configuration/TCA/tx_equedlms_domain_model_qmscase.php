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
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'origin' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.origin',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'linked_submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.linked_submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'linked_feedback' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.linked_feedback',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'linked_certificate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.linked_certificate',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'related_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.related_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'reported_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.reported_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'assigned_to' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.assigned_to',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'linked_course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.linked_course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'priority' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.priority',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'resolved_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.resolved_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'resolution_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.resolution_comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'resolution_upload' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.resolution_upload',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'escalated' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.escalated',
            'config' => [
                'type' => 'check'
            ]
        ],
        'escalated_to' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.escalated_to',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'visibility' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.visibility',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.tags',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'notes_json' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.notes_json',
            'config' => [
                'type' => 'text'
            ]
        ],
        'related_qmscase' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.related_qmscase',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_qmscase.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, origin, linked_submission, linked_feedback, linked_certificate, related_user, reported_by, assigned_to, linked_course_instance, status, priority, created_at, updated_at, resolved_at, resolution_comment, resolution_upload, escalated, escalated_to, visibility, tags, notes_json, related_qmscase, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,origin,linked_submission,linked_feedback,linked_certificate,related_user,reported_by,assigned_to,linked_course_instance,status,priority,created_at,updated_at,resolved_at,resolution_comment,resolution_upload,escalated,escalated_to,visibility,tags,notes_json,related_qmscase,uuid'
    ]
];
