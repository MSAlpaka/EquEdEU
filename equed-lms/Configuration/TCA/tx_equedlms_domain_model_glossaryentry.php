<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'            => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry',
        'label'            => 'term',
        'tstamp'           => 'tstamp',
        'crdate'           => 'crdate',
        'cruser_id'        => 'cruser_id',
        'versioningWS'     => true,
        'languageField'    => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete'           => 'deleted',
        'enablecolumns'    => [
            'disabled'  => 'hidden',
            'starttime' => 'starttime',
            'endtime'   => 'endtime',
        ],
        'searchFields'     => 'term,definition,term_key,definition_key',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'interface' => [
        'showRecordFieldList' => implode(',', [
            'sys_language_uid',
            'l10n_parent',
            'l10n_diffsource',
            'hidden',
            'term',
            'term_key',
            'definition',
            'definition_key',
            'course_program',
            'language',
            'is_archived',
            'uuid',
            'created_at',
            'updated_at',
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
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'default'       => 0,
                'items'         => [['', 0]],
                'foreign_table' => 'tx_equedlms_domain_model_glossaryentry',
                'foreign_table_where' => 'AND {#tx_equedlms_domain_model_glossaryentry}.{#pid}=###CURRENT_PID### AND {#tx_equedlms_domain_model_glossaryentry}.{#sys_language_uid} IN (-1,0)',
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
                'range'      => ['upper' => mktime(0, 0, 0, 1, 1, 2038)],
            ],
        ],
        'term' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.term',
            'config'  => [
                'type'     => 'input',
                'size'     => 30,
                'eval'     => 'trim,required',
            ],
        ],
        'term_key' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.term_key',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'definition' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.definition',
            'config'  => [
                'type'            => 'text',
                'cols'            => 40,
                'rows'            => 8,
                'eval'            => 'trim',
                'enableRichtext'  => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'definition_key' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.definition_key',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'course_program' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.course_program',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'minitems'      => 0,
                'maxitems'      => 1,
            ],
        ],
        'language' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.language',
            'config'  => [
                'type'    => 'input',
                'size'    => 5,
                'eval'    => 'trim',
                'default' => 'en',
            ],
        ],
        'is_archived' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.is_archived',
            'config' => [
                'type' => 'check',
            ],
        ],
        'uuid' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_glossaryentry.updated_at',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid, l10n_parent, l10n_diffsource,
                hidden, term, term_key, definition, definition_key, course_program, language, is_archived, uuid, created_at, updated_at,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                  starttime, endtime
            ',
        ],
    ],
];
