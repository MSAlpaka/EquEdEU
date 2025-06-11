
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_examtemplate', [
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
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'course_program' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examtemplate.course_program',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_equedlms_domain_model_courseprogram',
                'maxitems' => 1,
            ],
        ],
        'exam_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examtemplate.exam_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Theorie', 'theory'],
                    ['Praxis', 'practical'],
                    ['Fallbericht', 'case'],
                    ['Kombiniert', 'combined'],
                ],
                'default' => 'theory',
            ],
        ],
        'criteria' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examtemplate.criteria',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_examtemplatecriteria',
                'foreign_field' => 'exam_template',
                'maxitems' => 999,
                'appearance' => [
                    'collapseAll' => true,
                    'levelLinksPosition' => 'top',
                    'useSortable' => true,
                ],
            ],
        ],
        'required_score' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examtemplate.required_score',
            'config' => [
                'type' => 'number',
            ],
        ],
        'required_percentage' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:examtemplate.required_percentage',
            'config' => [
                'type' => 'number',
            ],
        ],
        'is_active' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'default' => 1,
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
        'tx_equedlms_domain_model_examtemplate',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        title, description, course_program, exam_type, criteria,
        required_score, required_percentage, is_active, uuid'
    );
})();
