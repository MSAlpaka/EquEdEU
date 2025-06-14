<?php
declare(strict_types=1);

namespace Equed\Core\Service;
if (!interface_exists(ClockInterface::class)) {
    interface ClockInterface { public function now(): \DateTimeImmutable; }
}
if (!interface_exists(UuidGeneratorInterface::class)) {
    interface UuidGeneratorInterface { public function generate(): string; }
}

namespace TYPO3\CMS\Extbase\Domain\Model;
if (!class_exists(FrontendUser::class)) {
    class FrontendUser
    {
        private array $properties = [];

        public function _setProperty(string $name, mixed $value): void
        {
            $this->properties[$name] = $value;
        }

        public function _getProperty(string $name): mixed
        {
            return $this->properties[$name] ?? null;
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Controller;

use Equed\EquedLms\Controller\Api\SyncController;
use Equed\EquedLms\Service\SyncService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Domain\Model\UserProfile;
use TYPO3\CMS\Core\Context\Context;
use Psr\Http\Message\ServerRequestInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\Core\Service\ClockInterface;
use Equed\EquedLms\Domain\Service\ClockInterface as DomainClockInterface;

class SyncControllerTest extends TestCase
{
    use ProphecyTrait;

    private SyncController $subject;
    private $service;
    private $repo;
    private $translator;
    private $context;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserProfileRepositoryInterface::class);
        $pm = $this->prophesize(PersistenceManagerInterface::class);
        $clock = $this->prophesize(DomainClockInterface::class);
        $this->service = new SyncService($this->repo->reveal(), $pm->reveal(), $clock->reveal());
        $this->translator = $this->prophesize(GptTranslationServiceInterface::class);
        $this->context = $this->prophesize(Context::class);

        $ref = new \ReflectionClass(SyncController::class);
        $this->subject = $ref->newInstanceWithoutConstructor();

        foreach (['syncService' => $this->service, 'profileRepository' => $this->repo->reveal(), 'translationService' => $this->translator->reveal(), 'context' => $this->context->reveal()] as $prop => $value) {
            $p = new \ReflectionProperty($this->subject, $prop);
            $p->setAccessible(true);
            $p->setValue($this->subject, $value);
        }
    }

    public function testPushActionLoadsProfileAndDelegates(): void
    {
        $req = $this->prophesize(ServerRequestInterface::class);
        $req->getQueryParams()->willReturn(['userId' => 5]);

        $profile = new UserProfile();
        $prop = new \ReflectionProperty($profile, 'clock');
        $prop->setAccessible(true);
        $prop->setValue($profile, new class implements ClockInterface {
            public function now(): \DateTimeImmutable { return new \DateTimeImmutable('2024-01-01T00:00:00+00:00'); }
        });
        $prop = new \ReflectionProperty($profile, 'uuidGenerator');
        $prop->setAccessible(true);
        $prop->setValue($profile, new class implements \Equed\Core\Service\UuidGeneratorInterface { public function generate(): string { return 'u1'; } });
        $profile->initializeObject();
        $profile->setFeUser(5);
        $profile->setDisplayName('John');
        $profile->setLanguage('en');
        $profile->setCountry('US');

        $this->repo->findByUserId(5)->willReturn($profile)->shouldBeCalled();

        $res = $this->subject->pushAction($req->reveal());
        $this->assertInstanceOf(JsonResponse::class, $res);
    }
}
