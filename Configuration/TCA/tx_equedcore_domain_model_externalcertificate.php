<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate',
        'label' => 'certificate_number',
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
        'searchFields' => 'certificate_number',
        'iconfile' => 'EXT:equed_core/Resources/Public/Icons/tx_equedcore_domain_model_externalcertificate.svg',
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
                'foreign_table' => 'tx_equedcore_domain_model_externalcertificate',
                'foreign_table_where' => 'AND {#tx_equedcore_domain_model_externalcertificate}.{#pid}=###CURRENT_PID### AND {#tx_equedcore_domain_model_externalcertificate}.{#sys_language_uid} IN (-1,0)',
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
        'certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate.certificate_number',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'issued_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate.issued_by',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'issue_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate.issue_date',
            'config' => [
                'type' => 'input',
                'size' => 12,
                'eval' => 'date',
            ],
        ],
        'related_document' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate.related_document',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedcore_domain_model_documentupload',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'is_valid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:tx_equedcore_domain_model_externalcertificate.is_valid',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
    'palettes' => [
        'qmsCertificate' => [
            'showitem' => 'certificate_number, issued_by, issue_date, --linebreak--, is_valid',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                certificate_number, issued_by, issue_date, related_document, is_valid,
                --palette--;QMS;qmsCertificate,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden, starttime, endtime
            ',
        ],
    ],
];
