
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_coursebookingrequest', [
        'requested_by' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.requested_by',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'course_program' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.course_program',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseprogram',
                'maxitems' => 1,
            ],
        ],
        'preferred_center' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.preferred_center',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_trainingcenter',
                'maxitems' => 1,
            ],
        ],
        'preferred_instructor' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.preferred_instructor',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'preferred_date' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.preferred_date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'comments' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.comments',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'status' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Offen', 'open'],
                    ['Zugewiesen', 'assigned'],
                    ['Abgelehnt', 'rejected'],
                    ['Bestätigt', 'confirmed'],
                    ['Storniert', 'cancelled'],
                ],
                'default' => 'open',
            ],
        ],
        'assigned_instance' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:coursebookingrequest.assigned_instance',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseinstance',
                'maxitems' => 1,
            ],
        ],
        'created_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.creationDate',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.lastUpdate',
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
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_coursebookingrequest',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        requested_by, course_program, preferred_center, preferred_instructor,
        preferred_date, comments, status, assigned_instance, created_at, updated_at, uuid'
    );
})();
