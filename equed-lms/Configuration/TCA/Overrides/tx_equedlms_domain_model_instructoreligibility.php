
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_instructoreligibility', [
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
        'course_program' => [
            'label' => 'Course Program',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_courseprogram',
                'renderType' => 'selectSingle',
            ],
        ],
        'eligibility_type' => [
            'label' => 'Eligibility Type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Automatic (based on completion)', 'auto'],
                    ['Manual Assignment', 'manual'],
                    ['Crossover', 'crossover'],
                    ['Grandfathered', 'grandfathered'],
                ],
                'default' => 'auto',
            ],
        ],
        'source_reference' => [
            'label' => 'Reference (e.g. Certificate, Crossover, Seminar)',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'is_examiner' => [
            'label' => 'May conduct exams?',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'is_certifier' => [
            'label' => 'May certify course completion?',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'approved_at' => [
            'label' => 'Approval Date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'expires_at' => [
            'label' => 'Valid Until',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'note' => [
            'label' => 'Admin Note',
            'config' => [
                'type' => 'text',
                'rows' => 3,
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
        'tx_equedlms_domain_model_instructoreligibility',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        fe_user, course_program, eligibility_type, source_reference,
        is_examiner, is_certifier, is_active,
        approved_at, expires_at, note, uuid, created_at, updated_at'
    );
})();
