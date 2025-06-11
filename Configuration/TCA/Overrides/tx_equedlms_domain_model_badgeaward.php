<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Badge Award',
        'label' => 'uuid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'uuid,badge_level,reason,context',
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
        'user' => [
            'exclude' => true,
            'label' => 'User UID',
            'config' => [
                'type' => 'input',
                'eval' => 'int,required',
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
        'reason' => [
            'exclude' => true,
            'label' => 'Reason',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'context' => [
            'exclude' => true,
            'label' => 'Context',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'awarded_at' => [
            'exclude' => true,
            'label' => 'Awarded At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => time(),
            ],
        ],
        'awarded_by' => [
            'exclude' => true,
            'label' => 'Awarded By UID',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'uuid, user, badge_level, reason, context, awarded_at, awarded_by'],
    ],
];
