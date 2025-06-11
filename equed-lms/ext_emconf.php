<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'EquEd LMS',
    'description' => 'LMS for Equine Education Europe – including course management, instructor workflows, QMS, and full SPA/App compatibility.',
    'category' => 'plugin',
    'state' => 'stable',
    'author' => 'Equine Education Europe',
    'author_email' => 'info@equed.eu',
    'version' => '1.0.0',
    'clearCacheOnLoad' => true,
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Equed\\EquedLms\\' => 'Classes/',
        ],
    ],
    'autoload-dev' => [
        'psr-4' => [
            'Equed\\EquedLms\\Tests\\' => 'Tests/',
        ],
    ],
    'icon' => 'EXT:equed_lms/Resources/Public/Icons/Extension.svg',
];
