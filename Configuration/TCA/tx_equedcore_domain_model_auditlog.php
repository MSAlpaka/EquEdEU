<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog',
        'label' => 'action',
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
        'searchFields' => 'uuid, action, user_id, user_hash, ip_address, details',
        'iconfile' => 'EXT:equed_core/Resources/Public/Icons/tx_equedcore_domain_model_auditlog.svg',
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
                'foreign_table' => 'tx_equedcore_domain_model_auditlog',
                'foreign_table_where' => 'AND {#tx_equedcore_domain_model_auditlog}.{#pid}=###CURRENT_PID### AND {#tx_equedcore_domain_model_auditlog}.{#sys_language_uid} IN (-1,0)',
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
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.uuid',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
            ],
        ],
        'user_hash' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.user_hash',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
            ],
        ],
        'details' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.details',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'action' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.action',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'user_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.user_id',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'ip_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_auditlog.ip_address',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim,ip',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                uuid, action, user_id, user_hash, ip_address, details,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden, starttime, endtime
            ',
        ],
    ],
];
