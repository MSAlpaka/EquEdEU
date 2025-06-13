<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'User Course Record',
        'label' => 'certificate_code',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'certificate_code,note_internal',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],

    'columns' => [
        'fe_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.fe_user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.course_instance',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseinstance',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'enrolled_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.enrolled_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'completed_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.completed_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'revoked_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.revoked_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'certificate_number' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'certificate_hash' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certificate_hash',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'badge_level' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.badge_level',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['None', 'none'],
                    ['Bronze', 'bronze'],
                    ['Silver', 'silver'],
                    ['Gold', 'gold'],
                ],
                'default' => 'none',
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:equed_lms/...:usercourserecord.status.aktiv', \Equed\EquedLms\Enum\UserCourseStatus::InProgress->value],
                    ['LLL:EXT:equed_lms/...:usercourserecord.status.abgeschlossen', \Equed\EquedLms\Enum\UserCourseStatus::Passed->value],
                    ['LLL:EXT:equed_lms/...:usercourserecord.status.abgebrochen', \Equed\EquedLms\Enum\UserCourseStatus::Failed->value],
                    ['LLL:EXT:equed_lms/...:usercourserecord.status.nicht_bestanden', \Equed\EquedLms\Enum\UserCourseStatus::Validated->value],
                ],
                'default' => \Equed\EquedLms\Enum\UserCourseStatus::InProgress->value,
            ],
        ],
        'progress_percent' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.progress_percent',
            'config' => [
                'type' => 'number',
                'default' => 0,
                'range' => ['lower' => 0, 'upper' => 100],
            ],
        ],
        'last_activity' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.last_activity',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'certifier' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certifier',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'instructor' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.instructor',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'certified_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certified_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'certificate_file' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certificate_file',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'certificate_file',
                ['maxitems' => 1],
                '*'
            ),
        ],
        'certificate_code' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.certificate_code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique',
            ],
        ],
        'requires_external_examiner' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.requires_external_examiner',
            'config' => [
                'type' => 'check',
            ],
        ],
        'external_examiner' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.external_examiner',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'validation_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.validation_required',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'validated_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.validated_by',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'validated_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.validated_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'qms_flagged' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.qms_flagged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'qms_case' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.qms_case',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_qmscase',
                'maxitems' => 1,
            ],
        ],
        'note_internal' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.note_internal',
            'config' => [
                'type' => 'text',
                'rows' => 3,
            ],
        ],
        'attempts_total' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.attempts_total',
            'config' => [
                'type' => 'number',
                'default' => 1,
            ],
        ],
        'recognition_awarded' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usercourserecord.recognition_awarded',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                fe_user, course_instance, enrolled_at, completed_at, revoked_at, status, progress_percent, last_activity,
                instructor, certifier, certified_at, certificate_file, certificate_code, certificate_number, certificate_hash, badge_level,
                requires_external_examiner, external_examiner, validation_required,
                validated_by, validated_at, qms_flagged, qms_case, note_internal,
                attempts_total, recognition_awarded, uuid, archived_attempts, passed_modules, external_certificate_flag, created_at, updated_at
            ',
        ],
    ],
];
