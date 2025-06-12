<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepository;
use Equed\EquedLms\Enum\SubmissionStatus;
use Equed\EquedLms\Service\SubmissionSyncService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class SubmissionSyncServiceTest extends TestCase
{
    use ProphecyTrait;

    private SubmissionSyncService $subject;
    private $repo;
    private $persistence;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserSubmissionRepository::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->subject = new SubmissionSyncService(
            $this->repo->reveal(),
            $this->persistence->reveal()
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
}
