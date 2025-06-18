<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Equed\EquedCore\Domain\Service\LmsIntegrationServiceInterface;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Lightweight client for forwarding data to an external LMS.
 */
class LmsIntegrationService implements LmsIntegrationServiceInterface
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

    /**
     * Push the instructor level for a user to the remote LMS.
     *
     * @param int    $userId User identifier
     * @param string $level  Instructor level
     * @return void
     */
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
