<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_course',
    [
        'title' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.title',
            'config'  => [
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.description',
            'config'  => [
                'type'            => 'text',
                'cols'            => 60,
                'rows'            => 8,
                'eval'            => 'trim',
                'enableRichtext'  => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'courseprogram' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.courseprogram',
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
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.start_date',
            'config'  => [
                'type'       => 'input',
                'renderType' => 'inputDateTime',
                'eval'       => 'date,required',
                'default'    => time(),
            ],
        ],
        'location' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_course.location',
            'config'  => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_course',
    'title, description, courseprogram, start_date, location',
    '',
    'after:title'
);
