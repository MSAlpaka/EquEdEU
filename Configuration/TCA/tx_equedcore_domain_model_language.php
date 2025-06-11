<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_language',
        'label' => 'language_iso',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'language_iso, label_en, label_de',
        'iconfile' => 'EXT:equed_core/Resources/Public/Icons/tx_equedcore_domain_model_language.svg',
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_equedcore_domain_model_language',
                'foreign_table_where' => 'AND {#tx_equedcore_domain_model_language}.{#pid}=###CURRENT_PID### AND {#tx_equedcore_domain_model_language}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.tstamp',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.crdate',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'cruser_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.cruser_id',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'language_iso' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_language.language_iso',
            'config' => [
                'type' => 'input',
                'size' => 2,
                'eval' => 'trim,alphanum,required,max=2',
            ],
        ],
        'label_en' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_language.label_en',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'label_de' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_language.label_de',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                language_iso, label_en, label_de,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden, starttime, endtime
            ',
        ],
    ],
];
