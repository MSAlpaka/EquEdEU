
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_lessonansweroption', [
        'lesson_question' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.lesson_question',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquestion',
                'maxitems' => 1,
            ],
        ],
        'sort_order' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.sort_order',
            'config' => [
                'type' => 'number',
                'default' => 100,
            ],
        ],
        'answer_text' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.answer_text',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 80,
            ],
        ],
        'is_correct' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.is_correct',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'feedback_if_selected' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.feedback_if_selected',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'cols' => 80,
            ],
        ],
        'feedback_if_not_selected' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.feedback_if_not_selected',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'cols' => 80,
            ],
        ],
        'media' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonansweroption.media',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'appearance' => [
                    'createNewRelationLinkTitle' => 'Datei hinzufügen',
                ],
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_lessonansweroption',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        lesson_question, sort_order, answer_text, is_correct,
        feedback_if_selected, feedback_if_not_selected, media'
    );
})();
