
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_usersubmission', [
        'frontend_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.frontend_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'lesson' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.lesson',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lesson',
                'maxitems' => 1,
            ],
        ],
        'submissionType' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.submission_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Fallbericht', 'case_report'],
                    ['Reflexion', 'reflection'],
                    ['Arbeitsblatt', 'worksheet'],
                    ['Upload', 'upload'],
                    ['Sonstiges', 'other'],
                ],
                'default' => 'upload',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.description',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'file_upload' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.file_upload',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
            ],
        ],
        'text_submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.text_submission',
            'config' => [
                'type' => 'text',
                'rows' => 10,
                'cols' => 80,
            ],
        ],
        'submitted_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.submitted_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'last_modified_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.last_modified_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Eingereicht', \Equed\EquedLms\Enum\SubmissionStatus::Pending->value],
                    ['In Bewertung', \Equed\EquedLms\Enum\SubmissionStatus::UnderReview->value],
                    ['Genehmigt', \Equed\EquedLms\Enum\SubmissionStatus::Approved->value],
                    ['Abgelehnt', \Equed\EquedLms\Enum\SubmissionStatus::Rejected->value],
                    ['Überarbeitung erforderlich', \Equed\EquedLms\Enum\SubmissionStatus::ResubmissionRequested->value],
                ],
                'default' => \Equed\EquedLms\Enum\SubmissionStatus::Pending->value,
            ],
        ],
        'needs_review' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.needs_review',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'reviewed_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.reviewed_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'reviewed_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.reviewed_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'feedback_comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.feedback_comment',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 80,
            ],
        ],
        'points_awarded' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.points_awarded',
            'config' => [
                'type' => 'number',
                'format' => 'float',
            ],
        ],
        'qms_flagged' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.qms_flagged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'qms_case' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.qms_case',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_qmscase',
                'maxitems' => 1,
            ],
        ],
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'visibility' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.visibility',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Privat', 'private'],
                    ['Instructor sichtbar', 'instructor'],
                    ['Öffentlich', 'public'],
                ],
                'default' => 'instructor',
            ],
        ],
        'language' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'tags' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.tags',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'related_submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:usersubmission.related_submission',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usersubmission',
                'maxitems' => 1,
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_usersubmission',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        frontend_user, course_instance, lesson, submissionType, title, description,
        file_upload, text_submission, submitted_at, last_modified_at, status, needs_review,
        reviewed_by, reviewed_at, feedback_comment, points_awarded, qms_flagged, qms_case,
        uuid, visibility, language, tags, related_submission'
    );
})();
