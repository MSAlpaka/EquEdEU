
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_lessonattempt', [
        'lesson_quiz' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.lesson_quiz',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_lessonquiz',
                'maxitems' => 1,
            ],
        ],
        'frontend_user' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.frontend_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'attempt_number' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.attempt_number',
            'config' => [
                'type' => 'number',
                'default' => 1,
            ],
        ],
        'score_percent' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.score_percent',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'score_raw' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.score_raw',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'max_points' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.max_points',
            'config' => [
                'type' => 'number',
                'format' => 'float',
                'default' => 0.0,
            ],
        ],
        'passed' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.passed',
            'config' => [
                'type' => 'check',
            ],
        ],
        'start_time' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.start_time',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'end_time' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.end_time',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'duration_sec' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.duration_sec',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'attempt_status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.attempt_status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['In Bearbeitung', 'in_progress'],
                    ['Eingereicht', 'submitted'],
                    ['Bewertet', 'graded'],
                    ['Ungültig', 'invalid'],
                ],
                'default' => 'submitted',
            ],
        ],
        'graded_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.graded_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'feedback' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.feedback',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 80,
            ],
        ],
        'qms_flagged' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.qms_flagged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'answers' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:lessonattempt.answers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_lessonattemptanswer',
                'foreign_field' => 'lesson_attempt',
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                ],
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_lessonattempt',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        lesson_quiz, frontend_user, attempt_number, score_percent, score_raw, max_points, passed,
        start_time, end_time, duration_sec, attempt_status, graded_by, feedback, qms_flagged, answers'
    );
})();
