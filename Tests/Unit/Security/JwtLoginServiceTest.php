<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Security;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Security\JwtLoginService;
use Equed\EquedCore\Security\TwoFactorService;

class JwtLoginServiceTest extends UnitTestCase
{
    public function testTokenCreationAndVerification(): void
    {
        $twoFa = new TwoFactorService();
        $service = new JwtLoginService($twoFa, 'secret');
        $token = $service->generateToken(['uid' => 1], 60);
        $payload = $service->verifyToken($token);
        $this->assertIsArray($payload);
        $this->assertSame(1, $payload['uid']);
    }

    public function testAuthenticateWithTwoFactor(): void
    {
        $twoFa = new TwoFactorService();
        $service = new JwtLoginService($twoFa, 'secret');
        $secret = 'JBSWY3DPEHPK3PXP';
        $code = $twoFa->generateCode($secret);
        $token = $service->generateToken(['2fa_code' => $code], 60);
        $record = [
            'tx_equedcore_2fa_enabled' => 1,
            'tx_equedcore_2fa_secret' => $secret,
        ];
        $this->assertTrue($service->authenticate($token, $record));
    }
}
