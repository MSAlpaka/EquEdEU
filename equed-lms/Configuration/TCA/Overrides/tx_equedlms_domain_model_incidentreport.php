
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_incidentreport', [
        'title' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.description',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 60,
            ],
        ],
        'report_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.report_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['General Incident', 'general'],
                    ['Animal Welfare', 'animal'],
                    ['Instructor Misconduct', 'instructor'],
                    ['Participant Behavior', 'participant'],
                    ['Health Issue', 'health'],
                    ['Technical Issue', 'technical'],
                    ['Other', 'other'],
                ],
                'default' => 'general',
            ],
        ],
        'reported_by' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'related_courseinstance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.related_courseinstance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'related_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.related_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'related_instructor' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.related_instructor',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'incident_date' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'location' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.location',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'upload_documents' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.upload_documents',
            'config' => [
                'type' => 'file',
                'maxitems' => 10,
            ],
        ],
        'requires_escalation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.requires_escalation',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'escalation_level' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:incidentreport.escalation_level',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['None', 'none'],
                    ['Certifier', 'certifier'],
                    ['ServiceCenter', 'service'],
                    ['QMS Lead', 'qms'],
                    ['External Authority', 'external'],
                ],
                'default' => 'none',
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Open', 'open'],
                    ['Under Review', 'review'],
                    ['Closed', 'closed'],
                    ['Escalated', 'escalated'],
                ],
                'default' => 'open',
            ],
        ],
        'notes_internal' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:notes',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.creationDate',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_incidentreport',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, report_type, reported_by, related_courseinstance,
        related_user, related_instructor, incident_date, location,
        upload_documents, requires_escalation, escalation_level, status,
        notes_internal, uuid, created_at'
    );
})();
