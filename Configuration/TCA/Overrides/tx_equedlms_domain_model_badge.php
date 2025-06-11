<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_badge',
    [
        'label' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badge.label',
            'config'  => [
                'type'    => 'input',
                'size'    => 40,
                'eval'    => 'trim,required',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badge.description',
            'config'  => [
                'type'   => 'text',
                'cols'   => 40,
                'rows'   => 5,
                'eval'   => 'trim',
            ],
        ],
        'icon' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_badge.icon',
            'config'  => ExtensionManagementUtility::getFileFieldTCAConfig(
                'icon',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference',
                    ],
                    'maxitems' => 1,
                    'minitems' => 0,
                ],
                'jpg,png,svg'
            ),
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_badge',
    'label, description, icon',
    '',
    'after:title'
);
