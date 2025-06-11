
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_practicequestion', [
        'practice_test' => [
            'label' => 'Practice Test',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_practicetest',
                'renderType' => 'selectSingle',
            ],
        ],
        'question_type' => [
            'label' => 'Question Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Single Choice', 'single'],
                    ['Multiple Choice', 'multiple'],
                    ['Text Input', 'text'],
                ],
                'default' => 'single',
            ],
        ],
        'question_text' => [
            'label' => 'Question Text',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'enableRichtext' => true,
            ],
        ],
        'image' => [
            'label' => 'Question Image',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'Add Image',
                ],
                'maxitems' => 1,
                'allowed' => ['jpg', 'jpeg', 'png', 'gif', 'svg'],
            ],
        ],
        'answers' => [
            'label' => 'Answer Options (JSON)',
            'config' => [
                'type' => 'text',
                'rows' => 6,
                'eval' => 'trim',
            ],
        ],
        'correct_answers' => [
            'label' => 'Correct Answers (JSON)',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'explanation' => [
            'label' => 'Explanation (shown after answer)',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'enableRichtext' => true,
            ],
        ],
        'position' => [
            'label' => 'Position',
            'config' => [
                'type' => 'number',
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
        'tx_equedlms_domain_model_practicequestion',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        practice_test, question_type, question_text, image,
        answers, correct_answers, explanation, position,
        language, uuid, created_at, updated_at'
    );
})();
