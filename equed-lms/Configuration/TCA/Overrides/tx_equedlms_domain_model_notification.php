
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Equed\EquedLms\Enum\NotificationType;
use Equed\EquedLms\Enum\NotificationStatus;

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
        'course_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.course_instance',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'submission' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.submission',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'user_course_record' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.user_course_record',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Info', NotificationType::Info->value],
                    ['Success', NotificationType::Success->value],
                    ['Warning', NotificationType::Warning->value],
                    ['Alert', NotificationType::Alert->value],
                    ['Certificate', NotificationType::Certificate->value],
                    ['Submission', NotificationType::Submission->value],
                    ['System', NotificationType::System->value],
                ],
                'default' => NotificationType::Info->value,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.status',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => NotificationStatus::Active->value,
            ],
        ],
        'is_read' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:label.read',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'is_archived' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:label.archived',
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
        'title_key' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:notification.title_key',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'custom_message' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.message',
            'config' => [
                'type' => 'text',
                'rows' => 4,
                'cols' => 60,
            ],
        ],
        'updated_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.updated',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_notification',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        recipient, course_instance, submission, user_course_record, type, status,
        is_read, is_archived, created_at, updated_at, uuid, language,
        title_key, custom_message'
    );
})();
