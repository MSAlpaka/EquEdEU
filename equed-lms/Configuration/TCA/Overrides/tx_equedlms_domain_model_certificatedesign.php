<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Certificate Design',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'name,description,font_family,template_file',
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
        'name' => [
            'exclude' => true,
            'label' => 'Name',
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
        'template_file' => [
            'exclude' => true,
            'label' => 'Template File',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'font_family' => [
            'exclude' => true,
            'label' => 'Font Family',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'background_color' => [
            'exclude' => true,
            'label' => 'Background Color',
            'config' => [
                'type' => 'input',
                'renderType' => 'colorpicker',
                'eval' => 'trim',
            ],
        ],
        'text_color' => [
            'exclude' => true,
            'label' => 'Text Color',
            'config' => [
                'type' => 'input',
                'renderType' => 'colorpicker',
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
        '1' => ['showitem' => 'uuid, name, description, template_file, font_family, background_color, text_color, active, created_at, updated_at'],
    ],
];
