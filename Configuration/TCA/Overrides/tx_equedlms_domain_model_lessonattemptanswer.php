
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_lessonattemptanswer', [
        'lesson_attempt' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.lesson_attempt',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonattempt',
                'maxitems' => 1,
            ],
        ],
        'lesson_question' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.lesson_question',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquestion',
                'maxitems' => 1,
            ],
        ],
        'question_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.question_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Einzelauswahl', 'mc_single'],
                    ['Mehrfachauswahl', 'mc_multiple'],
                    ['Freitext', 'text'],
                    ['Dateiupload', 'upload'],
                ],
                'default' => 'mc_single',
            ],
        ],
        'answer_text' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.answer_text',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'answer_option_ids' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.answer_option_ids',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'cols' => 60,
            ],
        ],
        'file_upload' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.file_upload',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'appearance' => [
                    'createNewRelationLinkTitle' => 'Datei hinzufügen',
                ],
            ],
        ],
        'is_correct' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.is_correct',
            'config' => [
                'type' => 'check',
            ],
        ],
        'points_awarded' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.points_awarded',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'max_points' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.max_points',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'requires_review' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.requires_review',
            'config' => [
                'type' => 'check',
            ],
        ],
        'reviewed_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.reviewed_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'instructor_comment' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.instructor_comment',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 80,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Ausstehend', 'pending'],
                    ['Richtig', 'correct'],
                    ['Falsch', 'incorrect'],
                    ['Teilweise korrekt', 'partial'],
                    ['Ungültig', 'invalid'],
                ],
                'default' => 'pending',
            ],
        ],
        'qms_flagged' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.qms_flagged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'evaluation_notes' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.evaluation_notes',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 80,
            ],
        ],
        'time_spent_sec' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.time_spent_sec',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'version_hash' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.version_hash',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'answer_uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattemptanswer.answer_uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_lessonattemptanswer',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        lesson_attempt, lesson_question, question_type, answer_text, answer_option_ids, file_upload,
        is_correct, points_awarded, max_points, requires_review, reviewed_by, instructor_comment,
        status, qms_flagged, evaluation_notes, time_spent_sec, version_hash, answer_uuid'
    );
})();
