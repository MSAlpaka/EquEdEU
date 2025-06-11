
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_instructoravailabilityregion', [
        'fe_user' => [
            'label' => 'Instructor',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'region_type' => [
            'label' => 'Region Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Zip Code', 'zipcode'],
                    ['State/Province', 'state'],
                    ['Country', 'country'],
                    ['Geo Location Radius', 'geo'],
                    ['Online Only', 'online_only'],
                ],
                'default' => 'zipcode',
            ],
        ],
        'region_value' => [
            'label' => 'Region Value (e.g. ZIP, State, JSON)',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'eval' => 'trim',
            ],
        ],
        'course_program' => [
            'label' => 'Limited to Course Program (optional)',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'renderType' => 'selectSingle',
            ],
        ],
        'priority' => [
            'label' => 'Matching Priority (higher = preferred)',
            'config' => [
                'type' => 'number',
                'default' => 50,
            ],
        ],
        'note' => [
            'label' => 'Note',
            'config' => [
                'type' => 'text',
                'rows' => 3,
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'created_at' => [
            'label' => 'Created At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'Updated At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_instructoravailabilityregion',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        fe_user, region_type, region_value, course_program, priority,
        note, is_active, uuid, created_at, updated_at'
    );
})();
