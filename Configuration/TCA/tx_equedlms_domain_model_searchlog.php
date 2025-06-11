<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog',
        'label' => 'fe_user',
        'hideTable' => true
    ],
    'columns' => [
        'fe_user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.fe_user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'query' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.query',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'results_found' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.results_found',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'context' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.context',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'ip_hash' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.ip_hash',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'user_agent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.user_agent',
            'config' => [
                'type' => 'text'
            ]
        ],
        'referer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.referer',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'timestamp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.timestamp',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_searchlog.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'fe_user, query, results_found, context, ip_hash, user_agent, referer, timestamp, uuid'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'fe_user,query,results_found,context,ip_hash,user_agent,referer,timestamp,uuid'
    ]
];
