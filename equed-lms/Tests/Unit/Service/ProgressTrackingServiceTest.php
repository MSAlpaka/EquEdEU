<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Factory\UserCourseRecordFactoryInterface;
use Equed\EquedLms\Enum\UserCourseStatus;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\ProgressTrackingService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class ProgressTrackingServiceTest extends TestCase
{
    use ProphecyTrait;

    private ProgressTrackingService $subject;
    private $recordRepo;
    private $instanceRepo;
    private $persistence;
    private $cache;
    private $language;
    private $recordFactory;

    protected function setUp(): void
    {
        $this->recordRepo   = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->instanceRepo = $this->prophesize(CourseInstanceRepositoryInterface::class);
        $this->persistence  = $this->prophesize(PersistenceManagerInterface::class);
        $this->cache        = $this->prophesize(CacheItemPoolInterface::class);
        $this->language     = $this->prophesize(LanguageServiceInterface::class);
        $this->recordFactory = $this->prophesize(UserCourseRecordFactoryInterface::class);

        $this->subject = new ProgressTrackingService(
            $this->recordRepo->reveal(),
            $this->instanceRepo->reveal(),
            $this->persistence->reveal(),
            $this->cache->reveal(),
            $this->language->reveal(),
            $this->recordFactory->reveal()
        );
    }

    public function testTrackProgressCreatesRecord(): void
    {
        $instance = new CourseInstance();
        $record   = new UserCourseRecord();
        $record->setCourseInstance($instance);

        $this->instanceRepo->findByUid(7)->willReturn($instance);
        $this->recordRepo->findOneByUserAndCourseInstance(5, 7)->willReturn(null);
        $this->recordFactory->createForUserAndInstance(5, $instance)->willReturn($record);
        $this->recordRepo->add($record)->shouldBeCalled();
        $this->recordRepo->update(\Prophecy\Argument::type(UserCourseRecord::class))->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();
        $this->cache->deleteItem('progress_5_7')->shouldBeCalled();

        $record = $this->subject->trackProgress(5, 7, 100.0);
        $this->assertSame(100.0, $record->getProgressPercent());
        $this->assertSame(UserCourseStatus::Validated, $record->getStatus());
    }

    public function testGetStatusLabelUsesTranslator(): void
    {
        $this->language->translate('status.completed')->willReturn('fertig');

        $this->assertSame('fertig', $this->subject->getStatusLabel('completed'));
    }
}
