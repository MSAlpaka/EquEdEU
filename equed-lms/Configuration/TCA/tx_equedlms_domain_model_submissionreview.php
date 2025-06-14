<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview',
        'label' => 'submission',
        'hideTable' => true
    ],
    'columns' => [
        'submission' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'reviewed_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.reviewed_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Open', \Equed\EquedLms\Enum\SubmissionReviewStatus::Open->value],
                    ['Approved', \Equed\EquedLms\Enum\SubmissionReviewStatus::Approved->value],
                    ['Rejected', \Equed\EquedLms\Enum\SubmissionReviewStatus::Rejected->value],
                ],
                'default' => \Equed\EquedLms\Enum\SubmissionReviewStatus::Open->value,
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.comment',
            'config' => [
                'type' => 'text'
            ]
        ],
        'evaluation_document' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.evaluation_document',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'visible_for_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.visible_for_user',
            'config' => [
                'type' => 'check'
            ]
        ],
        'was_generated_by_gpt' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.was_generated_by_gpt',
            'config' => [
                'type' => 'check'
            ]
        ],
        'lang' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_submissionreview.lang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'submission, reviewed_by, status, comment, evaluation_document, visible_for_user, was_generated_by_gpt, lang'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'submission,reviewed_by,status,comment,evaluation_document,visible_for_user,was_generated_by_gpt,lang'
    ]
];
