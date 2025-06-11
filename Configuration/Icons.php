<?php

declare(strict_types=1);
defined('TYPO3') or die();

return [
    'equed-certificate' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:equed_lms/Resources/Public/Icons/certificate.svg',
    ],
    'equed-qms' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:equed_lms/Resources/Public/Icons/qms.svg',
    ],
    'equed-user-badge' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:equed_lms/Resources/Public/Icons/badge.svg',
    ],
];
