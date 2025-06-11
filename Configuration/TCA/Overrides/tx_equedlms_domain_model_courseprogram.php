<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_courseprogram',
    [
        'badge_icon' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.badge_icon',
            'config'  => ExtensionManagementUtility::getFileFieldTCAConfig(
                'badge_icon',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference',
                    ],
                    'maxitems' => 1,
                ],
                'jpg,png,svg'
            ),
        ],
        'requires_external_examiner' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.requires_external_examiner',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 0,
            ],
        ],
        'certifier_must_validate' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.certifier_must_validate',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 0,
            ],
        ],
        'recertification_required' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.recertification_required',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 0,
            ],
        ],
        'recertification_interval_years' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.recertification_interval_years',
            'config'  => [
                'type'    => 'input',
                'eval'    => 'int',
                'default' => 3,
            ],
        ],
        'visible_in_catalog' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseprogram.visible_in_catalog',
            'config'  => [
                'type'    => 'check',
                'items'   => [['', '']],
                'default' => 1,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_courseprogram',
    'badge_icon, requires_external_examiner, certifier_must_validate, recertification_required, recertification_interval_years, visible_in_catalog',
    '',
    'after:certificate_type'
);
