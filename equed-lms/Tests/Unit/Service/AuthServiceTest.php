<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepository;
use Equed\EquedLms\Service\AuthService;
use Equed\EquedLms\Enum\UserRole;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    use ProphecyTrait;

    private AuthService $subject;
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(UserProfileRepository::class);
        $this->subject = new AuthService(
            $this->repository->reveal()
        );
    }

    public function testReturnsCertifierRole(): void
    {
        $profile = $this->prophesize(UserProfile::class);
        $profile->isCertifier()->willReturn(true);
        $profile->isInstructor()->shouldNotBeCalled();
        $this->repository->findByFeUser(5)->willReturn($profile->reveal());

        $this->assertSame(UserRole::Certifier, $this->subject->getUserRole(5));
    }

    public function testReturnsInstructorRole(): void
    {
        $profile = $this->prophesize(UserProfile::class);
        $profile->isCertifier()->willReturn(false);
        $profile->isInstructor()->willReturn(true);
        $this->repository->findByFeUser(7)->willReturn($profile->reveal());

        $this->assertSame(UserRole::Instructor, $this->subject->getUserRole(7));
    }

    public function testReturnsLearnerIfNoProfile(): void
    {
        $this->repository->findByFeUser(9)->willReturn(null);

        $this->assertSame(UserRole::Learner, $this->subject->getUserRole(9));
    }
}
