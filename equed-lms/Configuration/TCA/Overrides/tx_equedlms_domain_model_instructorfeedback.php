
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_instructorfeedback', [
        'frontend_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.frontend_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'instructor_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.instructor_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'lesson' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.lesson',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lesson',
                'maxitems' => 1,
            ],
        ],
        'user_submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.user_submission',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_usersubmission',
                'maxitems' => 1,
            ],
        ],
        'lesson_attempt' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.lesson_attempt',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonattempt',
                'maxitems' => 1,
            ],
        ],
        'feedback_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.feedback_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Submission', 'submission'],
                    ['Quiz', 'quiz'],
                    ['Praxisprüfung', 'practical_exam'],
                    ['Abschlussfeedback', 'final_review'],
                    ['Sonstiges', 'other'],
                ],
                'default' => 'submission',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.comment',
            'config' => [
                'type' => 'text',
                'rows' => 10,
                'cols' => 80,
            ],
        ],
        'rating' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.rating',
            'config' => [
                'type' => 'number',
                'format' => 'float',
            ],
        ],
        'recommendation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.recommendation',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 80,
            ],
        ],
        'attachment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.attachment',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
            ],
        ],
        'submitted_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.submitted_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'visible_to_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.visible_to_user',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'qms_flagged' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.qms_flagged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'qms_case' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.qms_case',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_qmscase',
                'maxitems' => 1,
            ],
        ],
        'feedback_uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.feedback_uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'revision_of' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.revision_of',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_instructorfeedback',
                'maxitems' => 1,
            ],
        ],
        'language' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'is_final' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.is_final',
            'config' => [
                'type' => 'check',
            ],
        ],
        'is_automated' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:instructorfeedback.is_automated',
            'config' => [
                'type' => 'check',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_instructorfeedback',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        frontend_user, instructor_user, course_instance, lesson, user_submission, lesson_attempt,
        feedback_type, title, comment, rating, recommendation, attachment, submitted_at,
        visible_to_user, qms_flagged, qms_case, feedback_uuid, revision_of, language, is_final, is_automated'
    );
})();
