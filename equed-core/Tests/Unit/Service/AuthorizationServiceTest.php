<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Service;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Service\AuthorizationService;

class AuthorizationServiceTest extends UnitTestCase
{
    public function testRoleChecks(): void
    {
        $service = new AuthorizationService(['instructor']);
        $this->assertTrue($service->isInstructor());
        $this->assertFalse($service->isCertifier());
        $this->assertFalse($service->isServiceCenter());
    }
}
