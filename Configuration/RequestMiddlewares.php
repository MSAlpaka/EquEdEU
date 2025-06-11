<?php

declare(strict_types=1);
return [
    'frontend' => [
        'equed-lms/cors' => [
            'target' => \Equed\EquedLms\Middleware\LmsCorsMiddleware::class,
            'after' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
            'before' => [
                'typo3/cms-frontend/base-redirect-resolver',
            ],
        ],
        'equed-lms/language' => [
            'target' => \Equed\EquedLms\Middleware\LanguageMiddleware::class,
            'after' => ['equed-lms/cors'],
            'before' => ['typo3/cms-frontend/base-redirect-resolver'],
        ],
        'equed-lms/logging' => [
            'target' => \Equed\EquedLms\Middleware\LmsLoggingMiddleware::class,
            'after' => ['equed-lms/language'],
        ],
        'equed-lms/token' => [
            'target' => \Equed\EquedLms\Middleware\ApiTokenMiddleware::class,
            'before' => ['equed-lms/user'],
        ],
        'equed-lms/user' => [
            'target' => \Equed\EquedLms\Middleware\FrontendUserMiddleware::class,
            'after' => ['equed-lms/token'],
        ],
        'equed-lms/course-access' => [
            'target' => \Equed\EquedLms\Middleware\CourseAccessMiddleware::class,
            'after' => ['equed-lms/user'],
        ],
    ],
];
