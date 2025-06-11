<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_lessonfeedback',
    'label' => 'text_feedback',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'delete' => 'deleted',
    'readOnly' => true,
    'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
  ],
  'columns' => [
    'user_course_record' => [
      'label' => 'User Course Record',
      'config' => [
        'type' => 'group',
        'internal_type' => 'db',
        'allowed' => 'tx_equedlms_domain_model_usercourserecord',
        'size' => 1,
        'maxitems' => 1,
        'readOnly' => true
      ]
    ],
    'text_feedback' => [
      'label' => 'Text Feedback',
      'config' => [
        'type' => 'text',
        'readOnly' => true
      ]
    ],
    'course_wish' => [
      'label' => 'Course Wish',
      'config' => [
        'type' => 'text',
        'readOnly' => true
      ]
    ]
  ],
  'types' => [
    '0' => ['showitem' => 'user_course_record, text_feedback, course_wish']
  ]
];
