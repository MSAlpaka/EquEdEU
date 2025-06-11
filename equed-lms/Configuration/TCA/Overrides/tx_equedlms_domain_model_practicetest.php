
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_practicetest', [
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'enableRichtext' => true,
            ],
        ],
        'course_program' => [
            'label' => 'Course Program',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'renderType' => 'selectSingle',
            ],
        ],
        'lesson' => [
            'label' => 'Related Lesson (optional)',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_lesson',
                'renderType' => 'selectSingle',
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'is_mandatory_for_progress' => [
            'label' => 'Affects Progress Tracking',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'estimated_duration' => [
            'label' => 'Estimated Duration (minutes)',
            'config' => [
                'type' => 'number',
            ],
        ],
        'shuffle_questions' => [
            'label' => 'Shuffle Questions',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'max_attempts' => [
            'label' => 'Max Attempts (0 = unlimited)',
            'config' => [
                'type' => 'number',
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
        'updated_at' => [
            'label' => 'Updated At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_practicetest',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, course_program, lesson, is_active, is_mandatory_for_progress,
        estimated_duration, shuffle_questions, max_attempts,
        language, uuid, created_at, updated_at'
    );
})();
