<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository {
    if (!interface_exists(BadgeAwardRepositoryInterface::class)) {
        interface BadgeAwardRepositoryInterface {
            public function addForCourse(int $userId, int $courseId, string $label): void;
            public function addForLearningPath(int $userId, int $pathId, string $label): void;
            public function findByFeUser(int $feUserId): array;
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\BadgeAwardService;
use Equed\EquedLms\Domain\Service\BadgeAwardServiceInterface;
use Equed\EquedLms\Domain\Repository\BadgeAwardRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LearningPathRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class BadgeAwardServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testAwardPendingBadgesAddsEntries(): void
    {
        $record = new class {
            public function __construct() { $this->user = new class { public function getUid(){return 1;} }; $this->course = new class { public function getUid(){return 2;} public function getTitle(){return 'Course';} }; }
            public function getFeUser(){ return $this->user; }
            public function getCourse(){ return $this->course; }
        };
        $path = new class {
            public function __construct() { $this->user = new class { public function getUid(){return 1;} }; }
            public function getFeUser(){ return $this->user; }
            public function getUid(){ return 3; }
            public function getTitle(){ return 'Path'; }
        };

        $awardRepo = $this->prophesize(BadgeAwardRepositoryInterface::class);
        $awardRepo->addForCourse(1, 2, 'c')->shouldBeCalled();
        $awardRepo->addForLearningPath(1, 3, 'p')->shouldBeCalled();

        $courseRepo = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $courseRepo->findCompletedWithoutBadge()->willReturn([$record]);
        $lpRepo = $this->prophesize(LearningPathRepositoryInterface::class);
        $lpRepo->findCompletedWithoutBadge()->willReturn([$path]);

        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('badge.course_completion', ['course' => 'Course'])->willReturn('c');
        $translator->translate('badge.learning_path_completion', ['path' => 'Path'])->willReturn('p');

        $service = new BadgeAwardService(
            $awardRepo->reveal(),
            $courseRepo->reveal(),
            $lpRepo->reveal(),
            $translator->reveal()
        );

        /** @var BadgeAwardServiceInterface $service */
        $count = $service->awardPendingBadges();
        $this->assertSame(2, $count);
    }
}
