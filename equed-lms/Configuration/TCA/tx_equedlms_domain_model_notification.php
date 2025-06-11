<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification',
        'label' => 'recipient',
        'hideTable' => true
    ],
    'columns' => [
        'recipient' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.recipient',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.type',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'message' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.message',
            'config' => [
                'type' => 'text'
            ]
        ],
        'payload' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.payload',
            'config' => [
                'type' => 'text'
            ]
        ],
        'related_model' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.related_model',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'related_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.related_uid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'is_read' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.is_read',
            'config' => [
                'type' => 'check'
            ]
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.created_at',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'valid_until' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.valid_until',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'priority' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.priority',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'uuid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.uuid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'language' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'send_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.send_email',
            'config' => [
                'type' => 'check'
            ]
        ],
        'send_push' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.send_push',
            'config' => [
                'type' => 'check'
            ]
        ],
        'channel' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.channel',
            'config' => [
                'type' => 'input',
                'eval' => 'int'
            ]
        ],
        'sender' => [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_notification.sender',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ],
    'types' => [
        1 => [
            'showitem' => 'recipient, type, title, message, payload, related_model, related_uid, is_read, created_at, valid_until, priority, uuid, language, send_email, send_push, channel, sender'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'recipient,type,title,message,payload,related_model,related_uid,is_read,created_at,valid_until,priority,uuid,language,send_email,send_push,channel,sender'
    ]
];
