<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_usermeta',
        'label' => 'meta_key',
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
        'searchFields' => 'meta_key, meta_value',
        'iconfile' => 'EXT:equed_core/Resources/Public/Icons/tx_equedcore_domain_model_usermeta.svg',
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
                'foreign_table' => 'tx_equedcore_domain_model_usermeta',
                'foreign_table_where' => 'AND {#tx_equedcore_domain_model_usermeta}.{#pid}=###CURRENT_PID### AND {#tx_equedcore_domain_model_usermeta}.{#sys_language_uid} IN (-1,0)',
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
        'user_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_usermeta.user_id',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'meta_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_usermeta.meta_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'meta_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_usermeta.meta_value',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'last_updated_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_usermeta.last_updated_date',
            'config' => [
                'type' => 'input',
                'size' => 12,
                'eval' => 'datetime',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                user_id, meta_key, meta_value, last_updated_date,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden, starttime, endtime
            ',
        ],
    ],
];
