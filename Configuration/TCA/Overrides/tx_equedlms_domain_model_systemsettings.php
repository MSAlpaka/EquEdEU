
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_systemsettings', [
        'setting_key' => [
            'label' => 'Setting Key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
            ],
        ],
        'value' => [
            'label' => 'Value',
            'config' => [
                'type' => 'text',
                'rows' => 4,
            ],
        ],
        'data_type' => [
            'label' => 'Data Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['String', 'string'],
                    ['Integer', 'integer'],
                    ['Boolean', 'boolean'],
                    ['JSON', 'json'],
                    ['Float', 'float'],
                ],
                'default' => 'string',
            ],
        ],
        'description' => [
            'label' => 'Description / Usage Hint',
            'config' => [
                'type' => 'text',
                'rows' => 3,
            ],
        ],
        'is_editable' => [
            'label' => 'Editable in Backend?',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'is_visible_to_admins' => [
            'label' => 'Visible to Admins Only?',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'group' => [
            'label' => 'Group / Category',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
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
        'tx_equedlms_domain_model_systemsettings',
        '--div--;General,
        setting_key, value, data_type, description, group,
        is_editable, is_visible_to_admins,
        uuid, created_at, updated_at'
    );
})();
