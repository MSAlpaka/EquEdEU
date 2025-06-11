
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_recognitionaward', [
        'title' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'rows' => 5,
            ],
        ],
        'badge_image' => [
            'label' => 'Badge Image',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => ['svg', 'png', 'jpg', 'jpeg'],
            ],
        ],
        'requirements_json' => [
            'label' => 'Requirements (JSON)',
            'config' => [
                'type' => 'text',
                'rows' => 6,
            ],
        ],
        'min_specialties_required' => [
            'label' => 'Minimum Specialties Required',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'min_practical_hours' => [
            'label' => 'Minimum Practical Hours',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'user_relation' => [
            'label' => 'User Relation',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'fe_users',
                'foreign_field' => 'recognition_award',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => true,
                ],
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'is_auto_granted' => [
            'label' => 'Automatically Granted',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'language' => [
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => 'en',
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
        'tx_equedlms_domain_model_recognitionaward',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, badge_image, requirements_json,
        min_specialties_required, min_practical_hours,
        is_auto_granted, is_active, language, uuid, created_at, updated_at'
    );
})();
