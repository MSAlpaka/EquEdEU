<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'                    => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress',
        'label'                    => 'lesson',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'versioningWS'             => true,
        'languageField'            => 'sys_language_uid',
        'transOrigPointerField'    => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
            'disabled'  => 'hidden',
            'starttime' => 'starttime',
            'endtime'   => 'endtime',
        ],
        'searchFields'             => 'lesson,progress,status,completed',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'interface' => [
        'showRecordFieldList' => implode(',', [
            'sys_language_uid',
            'l10n_parent',
            'l10n_diffsource',
            'hidden',
            'lesson',
            'fe_user',
            'user_course_record',
            'progress',
            'status',
            'uuid',
            'created_at',
            'updated_at',
            'completed',
            'starttime',
            'endtime',
        ]),
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'special'    => 'languages',
                'items'      => [[
                    'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                    -1,
                    'flags-multiple'
                ]],
                'default'    => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude'     => true,
            'label'       => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config'      => [
                'type'                => 'select',
                'renderType'          => 'selectSingle',
                'default'             => 0,
                'items'               => [['', 0]],
                'foreign_table'       => 'tx_equedlms_domain_model_lessonprogress',
                'foreign_table_where' => 'AND {#tx_equedlms_domain_model_lessonprogress}.{#pid}=###CURRENT_PID### AND {#tx_equedlms_domain_model_lessonprogress}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => ['type' => 'passthrough'],
        ],
        'hidden' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config'  => ['type' => 'check', 'items' => [['', '']]],
        ],
        'starttime' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config'  => [
                'type'         => 'input',
                'renderType'   => 'inputDateTime',
                'eval'         => 'datetime,int',
                'default'      => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config'  => [
                'type'         => 'input',
                'renderType'   => 'inputDateTime',
                'eval'         => 'datetime,int',
                'default'      => 0,
                'range'        => ['upper' => mktime(0, 0, 0, 12, 31, 2030)],
            ],
        ],
        'lesson' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.lesson',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_lesson',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'fe_user' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.fe_user',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'user_course_record' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.user_course_record',
            'config'  => [
                'type' => 'input',
                'eval' => 'int'
            ],
        ],
        'progress' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.progress',
            'config'  => [
                'type'     => 'input',
                'size'     => 4,
                'eval'     => 'int,required',
                'default'  => 0,
            ],
        ],
        'status' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.status',
            'config'  => [
                'type'    => 'input',
                'default' => 'notStarted',
            ],
        ],
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
        'completed' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonprogress.completed',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 0,
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid, l10n_parent, l10n_diffsource,
                hidden, lesson, fe_user, user_course_record, progress, status, uuid, created_at, updated_at, completed,
                --div--;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:tabs.access,
                  starttime, endtime
            ',
        ],
    ],
];
