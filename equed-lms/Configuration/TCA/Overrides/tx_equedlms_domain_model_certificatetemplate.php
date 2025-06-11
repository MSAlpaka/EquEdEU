<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
    'tx_equedlms_domain_model_certificatetemplate',
    [
        'uuid' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.uuid',
            'config'  => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
            ],
        ],
        'title' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.title',
            'config'  => [
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim,required',
            ],
        ],
        'title_key' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.title_key',
            'config'  => [
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.description',
            'config'  => [
                'type' => 'text',
            ],
        ],
        'course_program' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.course_program',
            'config'  => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'language' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.language',
            'config'  => [
                'type' => 'input',
                'size' => 5,
                'eval' => 'trim',
            ],
        ],
        'badge_level' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.badge_level',
            'config'  => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'design_type' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.design_type',
            'config'  => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
            ],
        ],
        'is_public' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config'  => [
                'type' => 'check',
            ],
        ],
        'background_file' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.background_file',
            'config'  => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'is_archived' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.archived',
            'config'  => [
                'type' => 'check',
            ],
        ],
        'created_at' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.created_at',
            'config'  => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'updated_at' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificatetemplate.updated_at',
            'config'  => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
    ]
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_equedlms_domain_model_certificatetemplate',
    'uuid, title, title_key, description, course_program, language, badge_level, design_type, is_public, background_file, is_archived, created_at, updated_at',
    '',
    'after:uuid'
);
