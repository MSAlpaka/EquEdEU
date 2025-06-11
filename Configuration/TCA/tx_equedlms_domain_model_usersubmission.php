<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission',
        'label' => 'frontend_user',
        'hideTable' => true
    ],
    'columns' => [
        'frontend_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.frontend_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'submissionType' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.submissionType',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'file_upload' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.file_upload',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'text_submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.text_submission',
            'config' => [
                'type' => 'text'
            ]
        ],
        'submitted_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.submitted_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'last_modified_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.last_modified_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'needs_review' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.needs_review',
            'config' => [
                'type' => 'check'
            ]
        ],
        'reviewed_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.reviewed_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'reviewed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.reviewed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'feedback_comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.feedback_comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'points_awarded' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.points_awarded',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'qms_flagged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.qms_flagged',
            'config' => [
                'type' => 'check'
            ]
        ],
        'qms_case' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.qms_case',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'visibility' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.visibility',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.tags',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'related_submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usersubmission.related_submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'frontend_user, course_instance, lesson, submissionType, title, description, file_upload, text_submission, submitted_at, last_modified_at, status, needs_review, reviewed_by, reviewed_at, feedback_comment, points_awarded, qms_flagged, qms_case, uuid, visibility, language, tags, related_submission'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'frontend_user,course_instance,lesson,submissionType,title,description,file_upload,text_submission,submitted_at,last_modified_at,status,needs_review,reviewed_by,reviewed_at,feedback_comment,points_awarded,qms_flagged,qms_case,uuid,visibility,language,tags,related_submission'
    ]
];
