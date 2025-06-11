
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_trainingcenter', [
        'name' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'center_id' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.center_id',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.description',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 80,
            ],
        ],
        'address' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.address',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'region' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.region',
            'config' => [
                'type' => 'input',
            ],
        ],
        'country' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.country',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-- LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.choose --', ''],
                    ['Germany', 'DE'],
                    ['Austria', 'AT'],
                    ['Switzerland', 'CH'],
                    ['France', 'FR'],
                    ['Italy', 'IT'],
                    ['Spain', 'ES'],
                    ['Kenya', 'KE'],
                    ['Other', 'XX'],
                ],
            ],
        ],
        'contact_email' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.email',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,email',
            ],
        ],
        'phone' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.phone',
            'config' => [
                'type' => 'input',
            ],
        ],
        'website' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.www',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'certified_until' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.certified_until',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Aktiv', 'active'],
                    ['Inaktiv', 'inactive'],
                    ['Gesperrt', 'suspended'],
                ],
                'default' => 'active',
            ],
        ],
        'allowed_programs' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.allowed_programs',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'foreign_field' => 'training_center',
                'maxitems' => 999,
            ],
        ],
        'instructors' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:trainingcenter.instructors',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'fe_users',
                'foreign_sortby' => 'last_name',
                'foreign_match_fields' => [
                    'usergroup' => 'Instructor',
                ],
                'maxitems' => 999,
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_trainingcenter',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        name, center_id, description, address, region, country, contact_email, phone, website,
        certified_until, status, allowed_programs, instructors, uuid'
    );
})();
