<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepository;
use Equed\EquedLms\Enum\SubmissionStatus;
use Equed\EquedLms\Service\SubmissionSyncService;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class SubmissionSyncServiceTest extends TestCase
{
    use ProphecyTrait;

    private SubmissionSyncService $subject;
    private $repo;
    private $persistence;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserSubmissionRepository::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);
        $this->subject = new SubmissionSyncService(
            $this->repo->reveal(),
            $this->persistence->reveal(),
            $this->clock->reveal()
        );
    }

    public function testPushExportsSubmissionData(): void
    {
        $submission = $this->prophesize(UserSubmission::class);
        $submission->getUuid()->willReturn('u1');
        $submission->getUser()->willReturn(5);
        $submission->getCourseInstance()->willReturn(3);
        $submission->getStatus()->willReturn(SubmissionStatus::Approved);
        $submission->getScore()->willReturn(1.5);
        $submission->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-01'));
        $submission->getGptFeedback()->willReturn('good');

        $data = $this->subject->push($submission->reveal());
        $this->assertSame('u1', $data['uuid']);
        $this->assertSame(5, $data['userId']);
        $this->assertSame(3, $data['course']);
        $this->assertSame('approved', $data['status']);
        $this->assertSame(1.5, $data['score']);
        $this->assertSame('good', $data['gptFeedback']);
    }

    public function testPullCreatesNewSubmissionWhenNotExisting(): void
    {
        $this->repo->findByUuid('u2')->willReturn(null);
        $this->repo->add(\Prophecy\Argument::type(UserSubmission::class))->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $result = $this->subject->pull([
            'uuid' => 'u2',
            'userId' => 2,
            'course' => 9,
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(UserSubmission::class, $result);
    }

    public function testPullSkipsUpdateWhenLocalIsNewer(): void
    {
        $submission = $this->prophesize(UserSubmission::class);
        $submission->getUuid()->willReturn('u1');
        $submission->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-02'));
        $submission->getUid()->willReturn(5);

        $submission->setUser()->shouldNotBeCalled();
        $submission->setCourseInstance()->shouldNotBeCalled();
        $submission->setStatus()->shouldNotBeCalled();
        $submission->setScore()->shouldNotBeCalled();
        $submission->setGptFeedback()->shouldNotBeCalled();
        $submission->setUpdatedAt()->shouldNotBeCalled();

        $this->repo->findByUuid('u1')->willReturn($submission->reveal());
        $this->repo->update($submission->reveal())->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $this->subject->pull([
            'uuid' => 'u1',
            'userId' => 1,
            'course' => 2,
            'status' => 'approved',
            'updatedAt' => '2024-01-01T00:00:00+00:00',
        ]);
    }

    public function testPullUpdatesWhenRemoteIsNewer(): void
    {
        $submission = $this->prophesize(UserSubmission::class);
        $submission->getUuid()->willReturn('u3');
        $submission->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-01'));
        $submission->getUid()->willReturn(7);

        $submission->setUser(4)->shouldBeCalled();
        $submission->setCourseInstance(5)->shouldBeCalled();
        $submission->setStatus('submitted')->shouldBeCalled();
        $submission->setScore(2.0)->shouldBeCalled();
        $submission->setGptFeedback('fb')->shouldBeCalled();
        $this->clock->now()->willReturn(new \DateTimeImmutable('2024-02-01'));
        $submission->setUpdatedAt(new \DateTimeImmutable('2024-02-01'))->shouldBeCalled();

        $this->repo->findByUuid('u3')->willReturn($submission->reveal());
        $this->repo->update($submission->reveal())->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $this->subject->pull([
            'uuid' => 'u3',
            'userId' => 4,
            'course' => 5,
            'status' => 'submitted',
            'score' => 2.0,
            'gptFeedback' => 'fb',
            'updatedAt' => '2024-01-02T00:00:00+00:00',
        ]);
    }
}
