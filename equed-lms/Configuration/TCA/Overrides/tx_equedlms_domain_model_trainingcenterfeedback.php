
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_trainingcenterfeedback', [
        'related_trainingcenter' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenterfeedback.related_trainingcenter',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_trainingcenter',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenterfeedback.course_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'submitted_by' => [
            'label' => 'FE User',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'anonymous' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:anonymous',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'infrastructure_score' => [
            'label' => 'Infrastructure Score (1–5)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 1, 'upper' => 5],
            ],
        ],
        'instructor_score' => [
            'label' => 'Instructor Score (1–5)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 1, 'upper' => 5],
            ],
        ],
        'organization_score' => [
            'label' => 'Organization Score (1–5)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 1, 'upper' => 5],
            ],
        ],
        'recommendation_score' => [
            'label' => 'Recommendation Score (1–10)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 1, 'upper' => 10],
            ],
        ],
        'would_recommend' => [
            'label' => 'Would Recommend?',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'comments' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.comment',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 60,
            ],
        ],
        'free_suggestions' => [
            'label' => 'Suggestions or Wishes',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'feedback_type' => [
            'label' => 'Feedback Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Participant Feedback', 'participant'],
                    ['Instructor Feedback', 'instructor'],
                    ['QMS Review', 'qms'],
                    ['Anonymous Feedback', 'anonymous'],
                    ['Other', 'other'],
                ],
                'default' => 'participant',
            ],
        ],
        'course_type' => [
            'label' => 'Course Type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'status' => [
            'label' => 'Feedback Status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['New', 'new'],
                    ['Reviewed', 'reviewed'],
                    ['Archived', 'archived'],
                ],
                'default' => 'new',
            ],
        ],
        'is_internal' => [
            'label' => 'Internal Use Only',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'visible_to_center' => [
            'label' => 'Visible to Center?',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'reviewed_by_qms' => [
            'label' => 'Reviewed by QMS',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'language' => [
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => 'en',
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
            'label' => 'Created At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_trainingcenterfeedback',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        related_trainingcenter, course_instance, submitted_by, anonymous,
        infrastructure_score, instructor_score, organization_score, recommendation_score,
        would_recommend, comments, free_suggestions, feedback_type, course_type,
        status, is_internal, visible_to_center, reviewed_by_qms, language, uuid, created_at'
    );
})();
