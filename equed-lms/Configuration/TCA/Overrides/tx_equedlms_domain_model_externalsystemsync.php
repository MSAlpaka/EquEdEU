
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_externalsystemsync', [
        'system_name' => [
            'label' => 'External System Name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'integration_type' => [
            'label' => 'Integration Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['API Push', 'push'],
                    ['API Pull', 'pull'],
                    ['Webhook', 'webhook'],
                    ['Manual Export/Import', 'manual'],
                ],
                'default' => 'push',
            ],
        ],
        'endpoint_url' => [
            'label' => 'Endpoint / Target URL',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'auth_token' => [
            'label' => 'Authentication Token / API Key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'renderType' => 'input',
            ],
        ],
        'sync_scope' => [
            'label' => 'Sync Scope (e.g. certificates, users, courses)',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'last_synced_at' => [
            'label' => 'Last Synced At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'sync_status' => [
            'label' => 'Last Sync Status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['OK', 'ok'],
                    ['Failed', 'failed'],
                    ['Pending', 'pending'],
                ],
                'default' => 'pending',
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'log' => [
            'label' => 'Log Message / Result',
            'config' => [
                'type' => 'text',
                'rows' => 5,
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
        'tx_equedlms_domain_model_externalsystemsync',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        system_name, integration_type, endpoint_url, auth_token,
        sync_scope, last_synced_at, sync_status, log, is_active,
        uuid, created_at, updated_at'
    );
})();
