<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Hooks;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Hooks\CertificationHook;
use Equed\EquedCore\Service\LmsIntegrationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CertificationHookTest extends UnitTestCase
{
    public function testSyncInstructorLevelTriggeredForFeUsers(): void
    {
        $service = $this->createMock(LmsIntegrationService::class);
        $service->expects($this->once())
            ->method('syncInstructorLevel')
            ->with(42, 'basic');

        GeneralUtility::addInstance(LmsIntegrationService::class, $service);

        $hook = new CertificationHook();
        $hook->processDatamap_postProcessFieldArray(
            [],
            'fe_users',
            42,
            ['instructor_level' => 'basic']
        );
    }
}
