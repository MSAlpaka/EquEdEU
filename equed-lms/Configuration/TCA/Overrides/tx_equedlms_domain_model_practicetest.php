
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_practicetest', [
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
                'rows' => 4,
                'enableRichtext' => true,
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
        'gpt_evaluation_enabled' => [
            'label' => 'GPT Evaluation Enabled',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'evaluation_scheme' => [
            'label' => 'Evaluation Scheme',
            'config' => [
                'type' => 'text',
                'rows' => 4,
            ],
        ],
        'expected_file_types' => [
            'label' => 'Expected File Types',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'visible_from' => [
            'label' => 'Visible From',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'visible_until' => [
            'label' => 'Visible Until',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
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
        'tx_equedlms_domain_model_practicetest',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, course_program, gpt_evaluation_enabled, evaluation_scheme, expected_file_types,
        visible_from, visible_until, uuid, created_at, updated_at'
    );
})();
