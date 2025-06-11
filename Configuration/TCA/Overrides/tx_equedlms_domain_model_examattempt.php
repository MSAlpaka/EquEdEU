
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_examattempt', [
        'user' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'exam_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.exam_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Theorie', 'theory'],
                    ['Praxis', 'practical'],
                    ['Fallbericht', 'case'],
                    ['Kombiniert', 'combined'],
                ],
                'default' => 'theory',
            ],
        ],
        'exam_date' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.exam_date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['In Bearbeitung', 'in_progress'],
                    ['Eingereicht', 'submitted'],
                    ['Bewertet', 'reviewed'],
                    ['Abgeschlossen', 'finalized'],
                ],
                'default' => 'in_progress',
            ],
        ],
        'is_passed' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.is_passed',
            'config' => [
                'type' => 'check',
            ],
        ],
        'score_total' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.score_total',
            'config' => [
                'type' => 'number',
            ],
        ],
        'score_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.score_required',
            'config' => [
                'type' => 'number',
            ],
        ],
        'score_percentage' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.score_percentage',
            'config' => [
                'type' => 'number',
            ],
        ],
        'grader' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.grader',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'grader_comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.grader_comment',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 60,
            ],
        ],
        'attempt_data_json' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.attempt_data_json',
            'config' => [
                'type' => 'text',
                'enableRichtext' => false,
            ],
        ],
        'linked_submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.linked_submission',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usersubmission',
                'maxitems' => 1,
            ],
        ],
        'linked_quiz' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.linked_quiz',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquiz',
                'maxitems' => 1,
            ],
        ],
        'reviewed_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.reviewDate',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'allow_retake' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.allow_retake',
            'config' => [
                'type' => 'check',
            ],
        ],
        'retake_reason' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.retake_reason',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'grading_template' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examattempt.grading_template',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_examtemplate',
                'maxitems' => 1,
            ],
        ],
        'documents_upload' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.files',
            'config' => [
                'type' => 'file',
                'maxitems' => 5,
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_examattempt',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        user, course_instance, exam_type, exam_date, status, is_passed,
        score_total, score_required, score_percentage, grader, grader_comment,
        attempt_data_json, linked_submission, linked_quiz, reviewed_at,
        allow_retake, retake_reason, grading_template, documents_upload, uuid'
    );
})();
