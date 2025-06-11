<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_coursematerial',
    [
        'title' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursematerial.title',
            'config'  => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursematerial.description',
            'config'  => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 4,
                'eval' => 'trim',
            ],
        ],
        'file' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursematerial.file',
            'config'  => ExtensionManagementUtility::getFileFieldTCAConfig(
                'file',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:media.addFileReference',
                    ],
                    'maxitems' => 1,
                ],
                'pdf,docx,jpg,png,mp4'
            ),
        ],
        'courseprogram' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursematerial.courseprogram',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'access_level' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursematerial.access_level',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    ['Participants only', 'participants'],
                    ['Instructors only', 'instructors'],
                    ['All (incl. ServiceCenter)', 'all'],
                ],
                'default'    => 'participants',
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_coursematerial',
    'title, description, file, courseprogram, access_level',
    '',
    'after:crdate'
);
