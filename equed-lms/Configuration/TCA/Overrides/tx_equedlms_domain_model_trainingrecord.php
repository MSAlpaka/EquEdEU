<?php

declare(strict_types=1);

return [
  'ctrl' => [
    'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:tx_equedlms_domain_model_trainingrecord',
    'label' => 'title',
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'delete' => 'deleted',
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
        'maxitems' => 1
      ]
    ],
    'training_type' => [
      'label' => 'Training Type',
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
          ['Self-directed', 'self'],
          ['Guided', 'guided'],
          ['Live Session', 'live'],
          ['Observation', 'observation']
        ],
        'default' => 'self'
      ]
    ],
    'title' => [
      'label' => 'Title',
      'config' => [
        'type' => 'input',
        'required' => true,
        'size' => 50
      ]
    ],
    'description' => [
      'label' => 'Description',
      'config' => [
        'type' => 'text',
        'enableRichtext' => true
      ]
    ],
    'duration_hours' => [
      'label' => 'Duration (hours)',
      'config' => [
        'type' => 'number',
        'format' => 'float',
        'eval' => 'double2',
        'default' => 0.0
      ]
    ],
    'date' => [
      'label' => 'Date',
      'config' => [
        'type' => 'datetime'
      ]
    ],
    'proof_document' => [
      'label' => 'Proof Document',
      'config' => [
        'type' => 'file',
        'maxitems' => 1
      ]
    ],
    'is_validated' => [
      'label' => 'Validated',
      'config' => [
        'type' => 'check'
      ]
    ],
    'validated_by' => [
      'label' => 'Validated By',
      'config' => [
        'type' => 'input'
      ]
    ],
    'lang' => [
      'label' => 'Language',
      'config' => [
        'type' => 'input'
      ]
    ],
    'is_archived' => [
      'label' => 'Archived',
      'config' => [
        'type' => 'check'
      ]
    ],
    'final_score' => [
      'label' => 'Final Score',
      'config' => [
        'type' => 'number',
        'range' => ['lower' => 0, 'upper' => 100],
      ]
    ],
    'certificate_issued' => [
      'label' => 'Certificate Issued',
      'config' => [
        'type' => 'check',
        'default' => 0
      ]
    ],
    'certificate_number' => [
      'label' => 'Certificate Number',
      'config' => [
        'type' => 'input',
        'eval' => 'trim'
      ]
    ],
    'certificate_issued_at' => [
      'label' => 'Certificate Issued At',
      'config' => [
        'type' => 'datetime'
      ]
    ],
    'gpt_evaluation_data' => [
      'label' => 'GPT Evaluation Data',
      'config' => [
        'type' => 'text',
        'rows' => 4
      ]
    ],
    'feedback_received' => [
      'label' => 'Feedback Received',
      'config' => [
        'type' => 'check',
        'default' => 0
      ]
    ]
  ],
  'types' => [
    '0' => ['showitem' => 'user_course_record, training_type, title, description, duration_hours, date, proof_document, is_validated, validated_by, lang, is_archived, final_score, certificate_issued, certificate_number, certificate_issued_at, gpt_evaluation_data, feedback_received']
  ]
];
