<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Content Page',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'title,slug,bodytext,language',
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
        'title' => [
            'exclude' => true,
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'Slug',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,uniqueInPid',
            ],
        ],
        'bodytext' => [
            'exclude' => true,
            'label' => 'Body Text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'eval' => 'trim',
            ],
        ],
        'language' => [
            'exclude' => true,
            'label' => 'Language',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => 'en',
            ],
        ],
        'published' => [
            'exclude' => true,
            'label' => 'Published',
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
        'updated_at' => [
            'exclude' => true,
            'label' => 'Updated At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'uuid, title, slug, bodytext, language, published, created_at, updated_at'],
    ],
];
