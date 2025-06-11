<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessoncontentpage',
    'label' => 'title_key',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'delete' => 'deleted',
    'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
  ],
  'columns' => [
    'lesson' => [
      'label' => 'Lesson',
      'config' => [
        'type' => 'group',
        'internal_type' => 'db',
        'allowed' => 'tx_equedlms_domain_model_lesson',
        'size' => 1,
        'maxitems' => 1
      ]
    ],
    'title_key' => [
      'label' => 'Title Key',
      'config' => [
        'type' => 'input',
        'eval' => 'trim'
      ]
    ],
    'content' => [
      'label' => 'Content',
      'config' => [
        'type' => 'text',
        'enableRichtext' => true
      ]
    ],
    'icon_identifier' => [
      'label' => 'Icon Identifier',
      'config' => [
        'type' => 'input'
      ]
    ],
    'visibility_condition' => [
      'label' => 'Visibility Condition',
      'config' => [
        'type' => 'input'
      ]
    ]
  ],
  'types' => [
    '0' => ['showitem' => 'lesson, title_key, content, icon_identifier, visibility_condition']
  ]
];
