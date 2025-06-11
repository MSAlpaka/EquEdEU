<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Badge Definition',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'title,badge_level,criteria,description',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'columns' => [
        'uuid' => [
            'exclude' => true,
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'readOnly' => true,
                'eval' => 'trim,required',
            ],
        ],
        'badge_level' => [
            'exclude' => true,
            'label' => 'Badge Level',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['None', 'none'],
                    ['Basic', 'basic'],
                    ['Advanced', 'advanced'],
                    ['Expert', 'expert'],
                ],
                'eval' => 'required',
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'criteria' => [
            'exclude' => true,
            'label' => 'Criteria',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'active' => [
            'exclude' => true,
            'label' => 'Active',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'created_at' => [
            'exclude' => true,
            'label' => 'Created At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => time(),
            ],
        ],
        'updated_at' => [
            'exclude' => true,
            'label' => 'Updated At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => time(),
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'uuid, badge_level, title, description, criteria, active, created_at, updated_at'],
    ],
];
