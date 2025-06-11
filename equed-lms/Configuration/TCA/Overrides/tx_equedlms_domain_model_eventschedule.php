
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_eventschedule', [
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'rows' => 5,
            ],
        ],
        'course_instance' => [
            'label' => 'Course Instance',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_equedlms_domain_model_courseinstance',
            ],
        ],
        'start_datetime' => [
            'label' => 'Start Time',
            'config' => [
                'type' => 'datetime',
                'required' => true,
            ],
        ],
        'end_datetime' => [
            'label' => 'End Time',
            'config' => [
                'type' => 'datetime',
                'required' => true,
            ],
        ],
        'event_type' => [
            'label' => 'Event Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Mandatory', 'mandatory'],
                    ['Recommended', 'recommended'],
                    ['Optional', 'optional'],
                ],
                'default' => 'mandatory',
            ],
        ],
        'location' => [
            'label' => 'Location / Link',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'max_participants' => [
            'label' => 'Maximum Participants',
            'config' => [
                'type' => 'number',
                'range' => ['lower' => 0, 'upper' => 9999],
            ],
        ],
        'notes' => [
            'label' => 'Internal Notes',
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
        'tx_equedlms_domain_model_eventschedule',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, course_instance, start_datetime, end_datetime,
        event_type, location, max_participants, notes,
        is_active, language, uuid, created_at, updated_at'
    );
})();
