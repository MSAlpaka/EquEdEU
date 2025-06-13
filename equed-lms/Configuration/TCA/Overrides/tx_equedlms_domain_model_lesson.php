<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Lesson',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'title,description',
        'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'rows' => 6,
            ],
        ],
        'expected_duration' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.expected_duration',
            'config' => [
                'type' => 'number',
                'default' => 10,
            ],
        ],
        'module' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.module',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_module',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'sort_order' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.sort_order',
            'config' => [
                'type' => 'number',
                'default' => 100,
            ],
        ],
        'visible' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.visible',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'materials' => [
            'label' => 'LLL:EXT:equed_lms/...:lesson.materials',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_equedlms_domain_model_material',
                'foreign_field' => 'lesson',
                'maxitems' => 50,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                title, description, expected_duration,
                module, sort_order, visible, materials
            ',
        ],
    ],
];
