
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_lessonquestion', [
        'lesson_quiz' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.lesson_quiz',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquiz',
                'maxitems' => 1,
            ],
        ],
        'sort_order' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.sort_order',
            'config' => [
                'type' => 'number',
                'default' => 100,
            ],
        ],
        'question_text' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.question_text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'rows' => 5,
                'cols' => 80,
            ],
        ],
        'question_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.question_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Single Choice', 'mc_single'],
                    ['Multiple Choice', 'mc_multiple'],
                    ['Freitext', 'text'],
                    ['Upload', 'upload'],
                ],
                'default' => 'mc_single',
            ],
        ],
        'required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'points' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.points',
            'config' => [
                'type' => 'number',
                'default' => 1,
            ],
        ],
        'answers' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.answers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_lessonansweroption',
                'foreign_field' => 'lesson_question',
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'useSortable' => true,
                ],
                'maxitems' => 20,
            ],
        ],
        'sample_solution' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.sample_solution',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'explanation' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.explanation',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'external_review_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.external_review_required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'allow_partial_scoring' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.allow_partial_scoring',
            'config' => [
                'type' => 'check',
            ],
        ],
        'visible_in_attempt' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.visible_in_attempt',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Immer', 'always'],
                    ['Nach Abgabe', 'after_submit'],
                    ['Nie', 'never'],
                ],
                'default' => 'after_submit',
            ],
        ],
        'randomize_answers' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.randomize_answers',
            'config' => [
                'type' => 'check',
            ],
        ],
        'slug_anchor' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.slug_anchor',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,uniqueInPid',
            ],
        ],
        'question_id' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.question_id',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
                'default' => '',
            ],
        ],
        'tags' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonquestion.tags',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'cols' => 60,
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_lessonquestion',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        lesson_quiz, sort_order, question_text, question_type, required, points,
        answers, sample_solution, explanation, external_review_required, allow_partial_scoring,
        visible_in_attempt, randomize_answers, slug_anchor, question_id, tags'
    );
})();
