<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Certificate Dispatch',
        'label' => 'certificate_number',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'certificate_number,delivery_method,dispatch_status,tracking_code',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
                'readOnly' => true,
            ],
        ],
        'user' => [
            'exclude' => true,
            'label' => 'User UID',
            'config' => [
                'type' => 'input',
                'eval' => 'int,required',
            ],
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'Certificate Number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'delivery_method' => [
            'exclude' => true,
            'label' => 'Delivery Method',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Email', 'email'],
                    ['Postal', 'postal'],
                ],
                'eval' => 'required',
            ],
        ],
        'dispatch_status' => [
            'exclude' => true,
            'label' => 'Dispatch Status',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'tracking_code' => [
            'exclude' => true,
            'label' => 'Tracking Code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'delivery_address' => [
            'exclude' => true,
            'label' => 'Delivery Address',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'dispatched' => [
            'exclude' => true,
            'label' => 'Dispatched',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'Created At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'dispatched_at' => [
            'exclude' => true,
            'label' => 'Dispatched At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'uuid, user, certificate_number, delivery_method, dispatch_status, tracking_code, delivery_address, dispatched, created_at, dispatched_at'],
    ],
];
