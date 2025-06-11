<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate',
        'label' => 'user',
        'hideTable' => true
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.user',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'courseprogram' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.courseprogram',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'issued_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.issued_at',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.certificate_number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'file' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_certificate.file',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'user, courseprogram, issued_at, certificate_number, file'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'user,courseprogram,issued_at,certificate_number,file'
    ]
];
