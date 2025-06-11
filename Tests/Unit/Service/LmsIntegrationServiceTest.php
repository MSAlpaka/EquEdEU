<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Service;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Service\LmsIntegrationService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LmsIntegrationServiceTest extends UnitTestCase
{
    public function testSyncInstructorLevelSendsRequest(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://equed-lms.local/api/instructor',
                ['json' => ['user_id' => 5, 'level' => 'basic']]
            );

        $service = new LmsIntegrationService($client);
        $service->syncInstructorLevel(5, 'basic');
    }

    public function testApiBaseCanBeInjectedViaEnv(): void
    {
        putenv('EQUED_LMS_API_BASE=https://api.example.com');

        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://api.example.com/instructor',
                ['json' => ['user_id' => 5, 'level' => 'basic']]
            );

        $service = new LmsIntegrationService($client);
        $service->syncInstructorLevel(5, 'basic');

        putenv('EQUED_LMS_API_BASE');
    }
}
