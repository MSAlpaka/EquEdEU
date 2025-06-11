
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_eventbooking', [
        'user' => [
            'label' => 'User',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'event_schedule' => [
            'label' => 'Event Schedule',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_eventschedule',
            ],
        ],
        'booking_status' => [
            'label' => 'Booking Status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Pending', 'pending'],
                    ['Confirmed', 'confirmed'],
                    ['Cancelled', 'cancelled'],
                    ['Attended', 'attended'],
                ],
                'default' => 'pending',
            ],
        ],
        'comment' => [
            'label' => 'Comment',
            'config' => [
                'type' => 'text',
                'rows' => 3,
            ],
        ],
        'confirmed_by_instructor' => [
            'label' => 'Confirmed by Instructor',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'confirmation_datetime' => [
            'label' => 'Confirmation Time',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'cancelled_reason' => [
            'label' => 'Cancellation Reason',
            'config' => [
                'type' => 'text',
                'rows' => 2,
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
        'tx_equedlms_domain_model_eventbooking',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        user, event_schedule, booking_status, comment,
        confirmed_by_instructor, confirmation_datetime, cancelled_reason,
        language, uuid, created_at, updated_at'
    );
})();
