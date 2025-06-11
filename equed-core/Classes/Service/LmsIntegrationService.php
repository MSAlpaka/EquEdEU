<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LmsIntegrationService
{
    private const DEFAULT_API_URL = 'https://equed-lms.local/api';
    /**
     * Name of the environment variable that can override the base URL
     * used to communicate with the external LMS.
     */
    private const ENV_KEY = 'EQUED_LMS_API_BASE';

    private string $apiBase;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        ?string $apiBase = null
    ) {
        $this->apiBase = $apiBase
            ?? (string)(getenv(self::ENV_KEY) ?: self::DEFAULT_API_URL);
    }

    public function syncInstructorLevel(int $userId, string $level): void
    {
        $this->httpClient->request('POST', $this->apiBase . '/instructor', [
            'json' => [
                'user_id' => $userId,
                'level' => $level,
            ],
        ]);
    }
}
