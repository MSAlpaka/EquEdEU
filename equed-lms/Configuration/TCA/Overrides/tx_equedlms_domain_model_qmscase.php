
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_qmscase', [
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.description',
            'config' => [
                'type' => 'text',
                'rows' => 6,
                'cols' => 80,
            ],
        ],
        'origin' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.origin',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Submission', 'submission'],
                    ['Feedback', 'feedback'],
                    ['Zertifikat', 'certificate'],
                    ['Manuell', 'manual'],
                    ['Incident', 'incident'],
                ],
                'default' => 'manual',
            ],
        ],
        'linked_submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.linked_submission',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usersubmission',
                'maxitems' => 1,
            ],
        ],
        'linked_feedback' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.linked_feedback',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_instructorfeedback',
                'maxitems' => 1,
            ],
        ],
        'linked_certificate' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.linked_certificate',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_coursecertificate',
                'maxitems' => 1,
            ],
        ],
        'related_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.related_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'reported_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.reported_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'assigned_to' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.assigned_to',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'linked_course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.linked_course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Offen', 'open'],
                    ['In Prüfung', 'in_review'],
                    ['Gelöst', 'resolved'],
                    ['Eskalation', 'escalated'],
                    ['Geschlossen', 'closed'],
                ],
                'default' => 'open',
            ],
        ],
        'priority' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.priority',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Niedrig', 'low'],
                    ['Mittel', 'medium'],
                    ['Hoch', 'high'],
                    ['Kritisch', 'critical'],
                ],
                'default' => 'medium',
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
        'resolved_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.resolved_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'resolution_comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.resolution_comment',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'resolution_upload' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.resolution_upload',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
            ],
        ],
        'escalated' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.escalated',
            'config' => [
                'type' => 'check',
            ],
        ],
        'escalated_to' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.escalated_to',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'visibility' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.visibility',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Nur Admins', 'admin'],
                    ['Certifier', 'certifier'],
                    ['Instructor', 'instructor'],
                    ['User', 'user'],
                ],
                'default' => 'admin',
            ],
        ],
        'tags' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.tags',
            'config' => [
                'type' => 'input',
            ],
        ],
        'notes_json' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.notes_json',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'related_qmscase' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.related_qmscase',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_qmscase',
                'maxitems' => 1,
            ],
        ],
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:qmscase.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_qmscase',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, origin, linked_submission, linked_feedback, linked_certificate,
        related_user, reported_by, assigned_to, linked_course_instance,
        status, priority, created_at, updated_at, resolved_at,
        resolution_comment, resolution_upload, escalated, escalated_to,
        visibility, tags, notes_json, related_qmscase, uuid'
    );
})();
