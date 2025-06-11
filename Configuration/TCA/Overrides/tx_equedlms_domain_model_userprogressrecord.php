
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_userprogressrecord', [
        'user' => [
            'label' => 'FE User',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'label' => 'Course Instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'lesson' => [
            'label' => 'Lesson',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lesson',
                'maxitems' => 1,
            ],
        ],
        'lesson_page' => [
            'label' => 'Lesson Page',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'completed' => [
            'label' => 'Completed',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'completed_at' => [
            'label' => 'Completed At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'progress_percent' => [
            'label' => 'Progress (%)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 0, 'upper' => 100],
            ],
        ],
        'last_accessed_at' => [
            'label' => 'Last Accessed At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'attempt_count' => [
            'label' => 'Lesson Attempts',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'time_spent_seconds' => [
            'label' => 'Time Spent (sec)',
            'config' => [
                'type' => 'number',
            ],
        ],
        'feedback_submitted' => [
            'label' => 'Feedback Submitted',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'notes' => [
            'label' => 'Notes',
            'config' => [
                'type' => 'text',
                'rows' => 3,
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
        'updated_at' => [
            'label' => 'Updated At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_userprogressrecord',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        user, course_instance, lesson, lesson_page, completed, completed_at,
        progress_percent, last_accessed_at, attempt_count, time_spent_seconds,
        feedback_submitted, notes, uuid, created_at, updated_at'
    );
})();
