<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\TokenService;
use Equed\EquedLms\Service\TokenGeneratorInterface;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

if (!class_exists(FrontendUser::class)) {
    class FrontendUser
    {
        private ?string $apiToken = null;
        public function getApiToken(): ?string { return $this->apiToken; }
        public function setApiToken(?string $apiToken): void { $this->apiToken = $apiToken; }
    }
}

if (!interface_exists(TokenGeneratorInterface::class)) {
    interface TokenGeneratorInterface { public function generate(int $length): string; }
}

class FakeGenerator implements TokenGeneratorInterface
{
    public function generate(int $length): string
    {
        return str_repeat('a', $length);
    }
}

if (!interface_exists(PersistenceManagerInterface::class)) {
    interface PersistenceManagerInterface { public function persistAll(); }
}

final class TokenServiceTest extends TestCase
{
    use ProphecyTrait;

    private TokenService $subject;
    private $repo;
    private $pm;
    private TokenGeneratorInterface $generator;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(FrontendUserRepositoryInterface::class);
        $this->pm = $this->prophesize(PersistenceManagerInterface::class);
        $this->generator = new FakeGenerator();
        $this->subject   = new TokenService(
            $this->repo->reveal(),
            $this->pm->reveal(),
            $this->generator
        );
    }

    public function testGenerateTokenPersistsUser(): void
    {
        $user = new FrontendUser();
        $this->repo->update($user)->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $token = $this->subject->generateToken($user);

        $this->assertSame($token, $user->getApiToken());
        $this->assertSame(32, strlen($token));
    }

    public function testValidateTokenDelegatesToRepository(): void
    {
        $user = new FrontendUser();
        $this->repo->findByApiToken('abc')->willReturn($user);
        $this->assertSame($user, $this->subject->validateToken('abc'));
    }

    public function testInvalidateTokenClearsAndPersists(): void
    {
        $user = new FrontendUser();
        $user->setApiToken('old');
        $this->repo->update($user)->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $this->subject->invalidateToken($user);
        $this->assertNull($user->getApiToken());
    }

    public function testGenerateTokenUsesGenerator(): void
    {
        $gen = $this->prophesize(TokenGeneratorInterface::class);
        $gen->generate(16)->willReturn(str_repeat('\x01', 16))->shouldBeCalled();

        $service = new TokenService($this->repo->reveal(), $this->pm->reveal(), $gen->reveal());

        $user = new FrontendUser();
        $this->repo->update($user)->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $token = $service->generateToken($user);
        $this->assertSame(bin2hex(str_repeat('\x01', 16)), $token);
    }
}
