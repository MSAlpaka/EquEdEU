<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_courseinstance',
    [
        'courseprogram' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.courseprogram',
            'config'  => [
                'type'          => 'select',
                'renderType'    => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'minitems'      => 1,
                'maxitems'      => 1,
            ],
        ],
        'start_date' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.start_date',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'date',
                'default'    => time(),
            ],
        ],
        'end_date' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.end_date',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'date',
                'default'    => time(),
            ],
        ],
        'instructor' => [
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
        'location' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_courseinstance.location',
            'config'  => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'validation_mode' => [
            'exclude' => false,
            'label'   => 'Validation Mode',
            'config'  => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Instructor', 'instructor'],
                    ['Certifier', 'certifier'],
                    ['Service Center', 'servicecenter'],
                ],
                'default' => 'instructor',
            ],
        ],
        'access_policy' => [
            'exclude' => false,
            'label'   => 'Access Policy',
            'config'  => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_accesspolicy',
                'maxitems' => 1,
            ],
        ],
        'tags' => [
            'exclude' => false,
            'label'   => 'Tags',
            'config'  => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'metadata' => [
            'exclude' => false,
            'label'   => 'Metadata',
            'config'  => [
                'type' => 'text',
                'rows' => 4,
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_courseinstance',
    'courseprogram, start_date, end_date, instructor, location, validation_mode, access_policy, tags, metadata',
    '',
    'after:title'
);
