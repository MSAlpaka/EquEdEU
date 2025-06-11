<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_coursefeedback',
    'label' => 'user_course_record',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'delete' => 'deleted',
    'hideTable' => false,
    'readOnly' => true,
    'iconfile' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg'
  ],
  'columns' => [
    'user_course_record' => [
      'label' => 'UserCourseRecord',
      'config' => [
        'type' => 'group',
        'internal_type' => 'db',
        'allowed' => 'tx_equedlms_domain_model_usercourserecord',
        'size' => 1,
        'maxitems' => 1,
        'readOnly' => true
      ]
    ],
    'submitted_by_user' => [
      'label' => 'Submitted by',
      'config' => [
        'type' => 'group',
        'internal_type' => 'db',
        'allowed' => 'fe_users',
        'size' => 1,
        'maxitems' => 1,
        'readOnly' => true
      ]
    ],
    'comment' => [
      'label' => 'Comment',
      'config' => [
        'type' => 'text',
        'readOnly' => true
      ]
    ],
    'course_wishes' => [
      'label' => 'Course Wishes',
      'config' => [
        'type' => 'text',
        'readOnly' => true
      ]
    ]
  ],
  'types' => [
    '0' => ['showitem' => 'user_course_record, submitted_by_user, comment, course_wishes']
  ]
];
