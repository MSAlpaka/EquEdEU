<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'                    => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_learningpath',
        'label'                    => 'title',
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
        'searchFields'             => 'title,description,level',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'interface' => [
        'showRecordFieldList' => implode(',', [
            'sys_language_uid',
            'l10n_parent',
            'l10n_diffsource',
            'hidden',
            'title',
            'description',
            'level',
            'courses',
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
                'foreign_table'       => 'tx_equedlms_domain_model_learningpath',
                'foreign_table_where' => 'AND {#tx_equedlms_domain_model_learningpath}.{#pid}=###CURRENT_PID### AND {#tx_equedlms_domain_model_learningpath}.{#sys_language_uid} IN (-1,0)',
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
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'datetime,int',
                'default'    => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'datetime,int',
                'default'    => 0,
                'range'      => ['upper' => mktime(0, 0, 0, 12, 31, 2030)],
            ],
        ],
        'title' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_learningpath.title',
            'config'  => [
                'type'     => 'input',
                'size'     => 50,
                'eval'     => 'trim,required',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_learningpath.description',
            'config'  => [
                'type'            => 'text',
                'cols'            => 40,
                'rows'            => 8,
                'eval'            => 'trim',
                'enableRichtext'  => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'level' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_learningpath.level',
            'config'  => [
                'type'     => 'input',
                'eval'     => 'int',
                'default'  => 0,
            ],
        ],
        'courses' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_learningpath.courses',
            'config'  => [
                'type'          => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_course',
                'foreign_field' => 'learning_path',
                'appearance'    => [
                    'collapseAll' => true,
                    'useSortable' => true,
                ],
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, description, level, courses,
                --div--;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:tabs.access,
                    hidden, starttime, endtime
            ',
        ],
    ],
];
