<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Security;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Security\TwoFactorService;

class TwoFactorServiceTest extends UnitTestCase
{
    public function testGenerateAndVerifyCode(): void
    {
        $service = new TwoFactorService();
        $secret = 'JBSWY3DPEHPK3PXP';
        $code = $service->generateCode($secret, 1234567890);
        $this->assertTrue($service->verifyCode($secret, $code, 1234567890));
        $this->assertFalse($service->verifyCode($secret, '000000', 1234567890));
    }
}
