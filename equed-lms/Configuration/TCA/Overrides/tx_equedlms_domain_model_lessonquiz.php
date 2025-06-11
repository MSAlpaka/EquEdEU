
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_lessonquiz', [
        'title' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'lesson' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.lesson',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lesson',
                'maxitems' => 1,
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 80,
            ],
        ],
        'quiz_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.quiz_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Wissensabfrage', 'knowledge'],
                    ['Reflexion', 'reflection'],
                    ['Prüfung', 'exam'],
                ],
                'default' => 'knowledge',
            ],
        ],
        'pass_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.pass_required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'pass_percentage' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.pass_percentage',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 0, 'upper' => 100],
                'default' => 70,
            ],
        ],
        'max_attempts' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.max_attempts',
            'config' => [
                'type' => 'number',
                'default' => 3,
            ],
        ],
        'questions' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.questions',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_lessonquestion',
                'foreign_field' => 'lesson_quiz',
                'maxitems' => 100,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'useSortable' => true,
                ],
            ],
        ],
        'randomize_questions' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.randomize_questions',
            'config' => [
                'type' => 'check',
            ],
        ],
        'shuffle_answers' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.shuffle_answers',
            'config' => [
                'type' => 'check',
            ],
        ],
        'show_feedback_per_question' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.show_feedback_per_question',
            'config' => [
                'type' => 'check',
            ],
        ],
        'time_limit_sec' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.time_limit_sec',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'allow_back_navigation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.allow_back_navigation',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'external_grading_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.external_grading_required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'feedback_success' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.feedback_success',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 80,
            ],
        ],
        'feedback_fail' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.feedback_fail',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 80,
            ],
        ],
        'visible_in_overview' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.visible_in_overview',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'relevant_for_progress' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.relevant_for_progress',
            'config' => [
                'type' => 'check',
            ],
        ],
        'relevant_for_certification' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquiz.relevant_for_certification',
            'config' => [
                'type' => 'check',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_lessonquiz',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, lesson, description, quiz_type, pass_required, pass_percentage, max_attempts,
        questions, randomize_questions, shuffle_answers, show_feedback_per_question,
        time_limit_sec, allow_back_navigation, external_grading_required,
        feedback_success, feedback_fail,
        visible_in_overview, relevant_for_progress, relevant_for_certification'
    );
})();
