<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Course Access Map',
        'label' => 'uuid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'uuid,course_program_code,access_type',
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
        'course_program_code' => [
            'exclude' => true,
            'label' => 'Course Program Code',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'access_type' => [
            'exclude' => true,
            'label' => 'Access Type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['View', 'view'],
                    ['Edit', 'edit'],
                    ['Certify', 'certify'],
                ],
                'eval' => 'required',
            ],
        ],
        'granted' => [
            'exclude' => true,
            'label' => 'Granted',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'granted_at' => [
            'exclude' => true,
            'label' => 'Granted At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'expires_at' => [
            'exclude' => true,
            'label' => 'Expires At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'granted_by' => [
            'exclude' => true,
            'label' => 'Granted By UID',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'uuid, user, course_program_code, access_type, granted, granted_at, expires_at, granted_by'],
    ],
];
