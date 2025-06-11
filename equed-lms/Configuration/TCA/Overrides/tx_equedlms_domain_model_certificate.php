<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_certificate',
    [
        'user' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'courseprogram' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.courseprogram',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'issued_at' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.issued_at',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'datetime,required',
                'default'    => time(),
            ],
        ],
        'certificate_number' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.certificate_number',
            'config'  => [
                'type'    => 'input',
                'size'    => 30,
                'eval'    => 'trim,required,unique',
            ],
        ],
        'file' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.file',
            'config'  => ExtensionManagementUtility::getFileFieldTCAConfig(
                'file',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference',
                    ],
                    'maxitems' => 1,
                ],
                'pdf'
            ),
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_certificate',
    'user, courseprogram, issued_at, certificate_number, file',
    '',
    'after:crdate'
);
