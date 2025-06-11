<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Service\BadgeAwardService;
use Equed\EquedLms\Domain\Repository\BadgeAwardRepository;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use Equed\EquedLms\Domain\Repository\LearningPathRepository;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Model\LearningPath;

class BadgeAwardServiceTest extends TestCase
{
    use ProphecyTrait;

    private BadgeAwardService $subject;
    private $badgeRepo;
    private $userBadgeRepo;
    private $logger;

    protected function setUp(): void
    {
        $this->badgeRepo = $this->prophesize(BadgeRepository::class);
        $this->userBadgeRepo = $this->prophesize(UserBadgeRepository::class);
        $this->logger = $this->prophesize(LoggerInterface::class);

        $this->subject = new BadgeAwardService(
            $this->badgeRepo->reveal(),
            $this->userBadgeRepo->reveal(),
            $this->logger->reveal()
        );
    }

    public function testItAwardsBadge(): void
    {
        $user = new User();
        $this->badgeRepo->findByCode('HC1')->willReturn(['id' => 1]);
        $this->userBadgeRepo->assignBadge($user, ['id' => 1])->shouldBeCalled();

        $result = $this->subject->awardBadgeToUser($user, 'HC1');
        $this->assertTrue($result);
    }

    public function testItFailsOnInvalidBadge(): void
    {
        $user = new User();
        $this->badgeRepo->findByCode('???')->willReturn(null);
        $this->logger->warning('Invalid badge code: ???')->shouldBeCalled();

        $result = $this->subject->awardBadgeToUser($user, '???');
        $this->assertFalse($result);
    }
}
