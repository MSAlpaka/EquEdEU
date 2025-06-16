<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback',
        'label' => 'related_trainingcenter',
        'hideTable' => true
    ],
    'columns' => [
        'related_trainingcenter' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.related_trainingcenter',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'submitted_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.submitted_by',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'anonymous' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.anonymous',
            'config' => [
                'type' => 'check'
            ]
        ],
        'infrastructure_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.infrastructure_score',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'instructor_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.instructor_score',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'organization_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.organization_score',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'recommendation_score' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.recommendation_score',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'would_recommend' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.would_recommend',
            'config' => [
                'type' => 'check'
            ]
        ],
        'comments' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.comments',
            'config' => [
                'type' => 'text'
            ]
        ],
        'free_suggestions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.free_suggestions',
            'config' => [
                'type' => 'text'
            ]
        ],
        'feedback_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.feedback_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'course_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.course_type',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Submitted', 'submitted'],
                    ['Reviewed', 'reviewed'],
                ],
                'default' => 'submitted',
            ]
        ],
        'is_internal' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.is_internal',
            'config' => [
                'type' => 'check'
            ]
        ],
        'visible_to_center' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.visible_to_center',
            'config' => [
                'type' => 'check'
            ]
        ],
        'reviewed_by_qms' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.reviewed_by_qms',
            'config' => [
                'type' => 'check'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingcenterfeedback.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'related_trainingcenter, course_instance, submitted_by, anonymous, infrastructure_score, instructor_score, organization_score, recommendation_score, would_recommend, comments, free_suggestions, feedback_type, course_type, status, is_internal, visible_to_center, reviewed_by_qms, language, uuid, created_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'related_trainingcenter,course_instance,submitted_by,anonymous,infrastructure_score,instructor_score,organization_score,recommendation_score,would_recommend,comments,free_suggestions,feedback_type,course_type,status,is_internal,visible_to_center,reviewed_by_qms,language,uuid,created_at'
    ]
];
