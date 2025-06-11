<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'Course Certificate',
        'label' => 'uuid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'uuid,certificate_number,status,language',
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
        'user_course_record' => [
            'exclude' => true,
            'label' => 'User Course Record',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_usercourserecord',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
            ],
        ],
        'course_instance' => [
            'exclude' => true,
            'label' => 'Course Instance',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_equedlms_domain_model_courseinstance',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
            ],
        ],
        'frontend_user' => [
            'exclude' => true,
            'label' => 'Participant',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
            ],
        ],
        'certifier_user' => [
            'exclude' => true,
            'label' => 'Certifier',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
            ],
        ],
        'instructor_user' => [
            'exclude' => true,
            'label' => 'Instructor',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
            ],
        ],
        'certificate_number' => [
            'exclude' => true,
            'label' => 'Certificate Number',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,unique',
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
        'status' => [
            'exclude' => true,
            'label' => 'Status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Draft', 'draft'],
                    ['Issued', 'issued'],
                    ['Revoked', 'revoked'],
                ],
                'eval' => 'required',
            ],
        ],
        'issued_at' => [
            'exclude' => true,
            'label' => 'Issued At',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'Archived',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'uuid, user_course_record, course_instance, frontend_user, certifier_user, instructor_user, certificate_number, language, status, issued_at, is_archived'],
    ],
];
