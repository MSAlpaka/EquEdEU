
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_searchlog', [
        'fe_user' => [
            'label' => 'Frontend User',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'query' => [
            'label' => 'Search Query',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'results_found' => [
            'label' => 'Results Found',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
        'context' => [
            'label' => 'Search Context',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Course', 'course'],
                    ['Lesson', 'lesson'],
                    ['FAQ', 'faq'],
                    ['Glossary', 'glossary'],
                    ['User', 'user'],
                    ['Other', 'other'],
                ],
                'default' => 'other',
            ],
        ],
        'ip_hash' => [
            'label' => 'IP Hash (pseudonymized)',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'user_agent' => [
            'label' => 'User Agent',
            'config' => [
                'type' => 'text',
                'rows' => 2,
            ],
        ],
        'referer' => [
            'label' => 'Referer Page',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'timestamp' => [
            'label' => 'Search Time',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'required,unique,trim',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_searchlog',
        '--div--;Search Log,
        fe_user, query, results_found, context,
        ip_hash, user_agent, referer, timestamp, uuid'
    );
})();
