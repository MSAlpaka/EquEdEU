<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal',
        'label' => 'title',
        'hideTable' => true
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.description',
            'config' => [
                'type' => 'text'
            ]
        ],
        'course_program' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.course_program',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'lesson' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.lesson',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'is_core_goal' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.is_core_goal',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_visible_to_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.is_visible_to_user',
            'config' => [
                'type' => 'check'
            ]
        ],
        'goal_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.goal_type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'category' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.category',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'requirement_level' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.requirement_level',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'required_for_certification' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.required_for_certification',
            'config' => [
                'type' => 'check'
            ]
        ],
        'required_for_course_access' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.required_for_course_access',
            'config' => [
                'type' => 'check'
            ]
        ],
        'is_exam_relevant' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.is_exam_relevant',
            'config' => [
                'type' => 'check'
            ]
        ],
        'weighting' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.weighting',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.position',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.notes',
            'config' => [
                'type' => 'text'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursegoal.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'title, description, course_program, lesson, is_core_goal, is_visible_to_user, goal_type, category, requirement_level, required_for_certification, required_for_course_access, is_exam_relevant, weighting, position, notes, language, uuid, created_at, updated_at'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'title,description,course_program,lesson,is_core_goal,is_visible_to_user,goal_type,category,requirement_level,required_for_certification,required_for_course_access,is_exam_relevant,weighting,position,notes,language,uuid,created_at,updated_at'
    ]
];
