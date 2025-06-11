<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ArrayUtility;

$GLOBALS['TCA']['fe_users']['columns'] += [
    'api_token' => [
        'exclude' => 1,
        'label' => 'API Token',
        'config' => [
            'type' => 'input',
            'readOnly' => true,
            'size' => 60,
            'eval' => 'trim',
        ],
    ],
    'is_instructor' => [
        'exclude' => 1,
        'label' => 'Instructor',
        'config' => [
            'type' => 'check',
            'items' => [['', '']],
            'default' => 0,
        ],
    ],
    'instructor_role' => [
        'exclude' => 1,
        'label' => 'Instructor Role',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['-', ''],
                ['Basic', 'basic'],
                ['Specialty', 'specialty'],
                ['Advanced', 'advanced'],
                ['Trainer', 'trainer'],
                ['Certifier', 'certifier'],
                ['Master', 'master'],
                ['Instructor Trainer', 'trainer_level'],
                ['Instructor Certifier', 'certifier_level'],
                ['International Certifier', 'intl_certifier'],
            ],
        ],
    ],
    'instructor_verified_by' => [
        'exclude' => 1,
        'label' => 'Verified by (User UID)',
        'config' => [
            'type' => 'input',
            'eval' => 'int',
        ],
    ],
    'instructor_verified_at' => [
        'exclude' => 1,
        'label' => 'Verified at',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime',
        ],
    ],
    'co_teaching_count' => [
        'exclude' => 1,
        'label' => 'Co-Teaching Count',
        'config' => [
            'type' => 'input',
            'eval' => 'int',
            'default' => 0,
        ],
    ],
    'specialty_instructor_roles' => [
        'exclude' => 1,
        'label' => 'Specialty Instructor Roles',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'items' => [
                ['Donkey HoofCare (SPD)', 'SPD'],
                ['Rehabilitation HoofCare (SPR)', 'SPR'],
                ['Sport Horse HoofCare (SPS)', 'SPS'],
                ['Senior Horse HoofCare (SEN)', 'SEN'],
                ['Emergency & Ethics (EME)', 'EME'],
                ['Foal HoofCare (SPF)', 'SPF'],
                ['Transition & Barehoof Rehab (SPT)', 'SPT'],
                ['Communication in HoofCare (COM)', 'COM'],
            ],
            'size' => 6,
            'maxitems' => 10,
        ],
    ],
    'emt_completed' => [
        'exclude' => 1,
        'label' => 'Specialty EMT completed',
        'config' => [
            'type' => 'check',
            'items' => [['', '']],
            'default' => 0,
        ],
    ],
];

ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['fe_users']['types']['0'],
    [
        'showitem' => $GLOBALS['TCA']['fe_users']['types']['0']['showitem']
            . ',--div--;API,api_token'
            . ',--div--;Instructor,is_instructor,instructor_role,instructor_verified_by,instructor_verified_at'
            . ',--div--;Specialties,specialty_instructor_roles,co_teaching_count,emt_completed',
    ]
);
// EOF
