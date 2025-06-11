<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord',
        'label' => 'fe_user',
        'hideTable' => true
    ],
    'columns' => [
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'enrolled_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.enrolled_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'completed_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.completed_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'revoked_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.revoked_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_hash' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certificate_hash',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.badge_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.status',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'progress_percent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.progress_percent',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'last_activity' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.last_activity',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certifier',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.instructor',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certified_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certified_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_file' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certificate_file',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'certificate_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.certificate_code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'requires_external_examiner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.requires_external_examiner',
            'config' => [
                'type' => 'check'
            ]
        ],
        'external_examiner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.external_examiner',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'validation_required' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.validation_required',
            'config' => [
                'type' => 'check'
            ]
        ],
        'validated_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.validated_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'validated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.validated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'qms_flagged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.qms_flagged',
            'config' => [
                'type' => 'check'
            ]
        ],
        'qms_case' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.qms_case',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'note_internal' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.note_internal',
            'config' => [
                'type' => 'text'
            ]
        ],
        'attempts_total' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.attempts_total',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'recognition_awarded' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_usercourserecord.recognition_awarded',
            'config' => [
                'type' => 'check'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'fe_user, course_instance, enrolled_at, completed_at, revoked_at, certificate_number, certificate_hash, badge_level, status, progress_percent, last_activity, certifier, instructor, certified_at, certificate_file, certificate_code, requires_external_examiner, external_examiner, validation_required, validated_by, validated_at, qms_flagged, qms_case, note_internal, attempts_total, recognition_awarded'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'fe_user,course_instance,enrolled_at,completed_at,revoked_at,certificate_number,certificate_hash,badge_level,status,progress_percent,last_activity,certifier,instructor,certified_at,certificate_file,certificate_code,requires_external_examiner,external_examiner,validation_required,validated_by,validated_at,qms_flagged,qms_case,note_internal,attempts_total,recognition_awarded'
    ]
];
