<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_observationtemplate',
    'label' => 'title_key',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'delete' => 'deleted',
    'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
  ],
  'columns' => [
    'course_program' => [
      'label' => 'Course Program',
      'config' => [
        'type' => 'group',
        'internal_type' => 'db',
        'allowed' => 'tx_equedlms_domain_model_courseprogram',
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
    'description' => [
      'label' => 'Description',
      'config' => [
        'type' => 'text',
        'enableRichtext' => true
      ]
    ],
    'structure' => [
      'label' => 'Structure (JSON)',
      'config' => [
        'type' => 'text',
        'enableRichtext' => false
      ]
    ]
  ],
  'types' => [
    '0' => ['showitem' => 'course_program, title_key, description, structure']
  ]
];
