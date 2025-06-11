
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_coursegoal', [
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
                'enableRichtext' => true,
                'rows' => 5,
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
        'is_core_goal' => [
            'label' => 'Core Learning Goal',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'is_visible_to_user' => [
            'label' => 'Visible to Participants',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'goal_type' => [
            'label' => 'Goal Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Knowledge', 'knowledge'],
                    ['Skill', 'skill'],
                    ['Attitude', 'attitude'],
                ],
            ],
        ],
        'category' => [
            'label' => 'Goal Category',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'requirement_level' => [
            'label' => 'Requirement Level',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Basic', 'basic'],
                    ['Intermediate', 'intermediate'],
                    ['Advanced', 'advanced'],
                    ['Expert', 'expert'],
                ],
            ],
        ],
        'required_for_certification' => [
            'label' => 'Required for Certification',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'required_for_course_access' => [
            'label' => 'Required for Course Access',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'is_exam_relevant' => [
            'label' => 'Relevant for Exam',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'weighting' => [
            'label' => 'Weighting (%)',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 0, 'upper' => 100],
            ],
        ],
        'position' => [
            'label' => 'Position',
            'config' => [
                'type' => 'number',
            ],
        ],
        'notes' => [
            'label' => 'Internal Notes',
            'config' => [
                'type' => 'text',
                'rows' => 3,
            ],
        ],
        'language' => [
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'default' => 'en',
                'eval' => 'trim',
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
        'tx_equedlms_domain_model_coursegoal',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, course_program, lesson, is_core_goal, is_visible_to_user,
        goal_type, category, requirement_level, required_for_certification,
        required_for_course_access, is_exam_relevant, weighting, position,
        notes, language, uuid, created_at, updated_at'
    );
})();
