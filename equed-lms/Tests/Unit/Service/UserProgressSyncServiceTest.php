<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Enum\UserCourseStatus;
use Equed\EquedLms\Service\UserProgressSyncService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class UserProgressSyncServiceTest extends TestCase
{
    use ProphecyTrait;

    private UserProgressSyncService $subject;
    private $repo;
    private $persistence;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->subject = new UserProgressSyncService(
            $this->repo->reveal(),
            $this->persistence->reveal()
        );
    }

    public function testExportUserProgressMapsRecords(): void
    {
        $record = new UserCourseRecord();
        $record->_setProperty('uid', 5);
        $record->setStatus(UserCourseStatus::Passed);
        $record->setUpdatedAt(new \DateTimeImmutable('2024-01-02 12:00:00'));

        $this->repo->findByUserId(3)->willReturn([$record]);

        $result = $this->subject->exportUserProgress(3);
        $this->assertSame(5, $result[0]['recordId']);
        $this->assertSame('passed', $result[0]['status']);
        $this->assertSame('2024-01-02 12:00:00', $result[0]['updatedAt']);
    }

    public function testSyncUserProgressUpdatesRecords(): void
    {
        $record = new UserCourseRecord();
        $record->_setProperty('uid', 8);
        $record->setStatus(UserCourseStatus::InProgress);
        $record->setUpdatedAt(new \DateTimeImmutable('2024-01-01 00:00:00'));

        $this->repo->findByUid(8)->willReturn($record);
        $this->repo->update($record)->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $count = $this->subject->syncUserProgress([
            [
                'recordId' => 8,
                'status' => 'passed',
                'updatedAt' => '2024-01-02 00:00:00',
            ],
        ]);

        $this->assertSame(1, $count);
        $this->assertSame('passed', $record->getStatus()->value ?? (string)$record->getStatus());
    }
}
