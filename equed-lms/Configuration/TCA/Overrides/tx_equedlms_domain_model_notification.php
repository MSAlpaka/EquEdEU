
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_notification', [
        'recipient' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Info', 'info'],
                    ['Success', 'success'],
                    ['Warning', 'warning'],
                    ['Alert', 'alert'],
                    ['Certificate', 'certificate'],
                    ['Submission', 'submission'],
                    ['System', 'system'],
                ],
                'default' => 'info',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'message' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.message',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 60,
            ],
        ],
        'payload' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.payload',
            'config' => [
                'type' => 'text',
            ],
        ],
        'related_model' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.related_model',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'related_uid' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.uid',
            'config' => [
                'type' => 'number',
            ],
        ],
        'is_read' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:label.read',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.creationDate',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'valid_until' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'priority' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.priority',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Low', 'low'],
                    ['Normal', 'normal'],
                    ['High', 'high'],
                    ['Urgent', 'urgent'],
                ],
                'default' => 'normal',
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
        'language' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => 'en',
            ],
        ],
        'send_email' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.send_email',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'send_push' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.send_push',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'channel' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.channel',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['In-App', 'in-app'],
                    ['Email', 'email'],
                    ['App Push', 'app'],
                    ['SMS', 'sms'],
                ],
                'default' => 'in-app',
            ],
        ],
        'sender' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.sender',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => 'system',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_notification',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        recipient, type, title, message, payload, related_model, related_uid,
        is_read, created_at, valid_until, priority, uuid, language,
        send_email, send_push, channel, sender'
    );
})();
