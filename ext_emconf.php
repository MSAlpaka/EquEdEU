<?php
declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'Equine Education Europe Core',
    'description' => 'Basisfunktionen und QMS-Hooks f\u00fcr Equine Education Europe (DE/EN).',
    'category' => 'plugin',
    'author' => 'Equine Education Europe Ltd.',
    'author_email' => 'info@equed.eu',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.9.99',
            'php' => '8.2.0-8.3.99'
        ],
    ],
];
