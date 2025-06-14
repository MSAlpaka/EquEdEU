<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_qmscase', [
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
            ],
        ],
        'user_course_record' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.user_course_record',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usercourserecord',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'certifier' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.certifier',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'incident_report' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.incident_report',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_incidentreport',
                'maxitems' => 1,
            ],
        ],
        'finalized_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.finalized_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'title_key' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'case_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.case_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Violation', \Equed\EquedLms\Enum\QmsCaseType::Violation->value],
                    ['Complaint', \Equed\EquedLms\Enum\QmsCaseType::Complaint->value],
                    ['Audit', \Equed\EquedLms\Enum\QmsCaseType::Audit->value],
                ],
                'default' => \Equed\EquedLms\Enum\QmsCaseType::Violation->value,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Open', \Equed\EquedLms\Enum\QmsCaseStatus::Open->value],
                    ['In Progress', \Equed\EquedLms\Enum\QmsCaseStatus::InProgress->value],
                    ['Closed', \Equed\EquedLms\Enum\QmsCaseStatus::Closed->value],
                ],
                'default' => \Equed\EquedLms\Enum\QmsCaseStatus::Open->value,
            ],
        ],
        'priority' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.priority',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'violates_standard' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.violates_standard',
            'config' => [
                'type' => 'check',
            ],
        ],
        'standard_reference' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.standard_reference',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.comment',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'decision' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.decision',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'attachment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.attachment',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'visible_to_instructor' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.visible_to_instructor',
            'config' => [
                'type' => 'check',
            ],
        ],
        'visible_to_training_center' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.visible_to_training_center',
            'config' => [
                'type' => 'check',
            ],
        ],
        'visible_to_certifier' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.visible_to_certifier',
            'config' => [
                'type' => 'check',
            ],
        ],
        'is_archived' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.is_archived',
            'config' => [
                'type' => 'check',
            ],
        ],
        'language' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.created_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.updated_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_qmscase',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, uuid, user_course_record, course_instance, certifier, incident_report, finalized_by, title, title_key, case_type, status, priority, violates_standard, standard_reference, comment, decision, attachment, visible_to_instructor, visible_to_training_center, visible_to_certifier, is_archived, language, created_at, updated_at'
    );
})();
