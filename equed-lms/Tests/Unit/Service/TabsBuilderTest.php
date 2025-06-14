<?php
declare(strict_types=1);

namespace {
    if (!class_exists('Equed\\EquedLms\\Domain\\Model\\FrontendUser', false)) {
        class_alias(\stdClass::class, 'Equed\\EquedLms\\Domain\\Model\\FrontendUser');
    }
}

namespace Equed\EquedLms\Tests\Unit\Service {

use DateTimeImmutable;
use Equed\EquedLms\Service\Dashboard\TabsBuilder;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Enum\UserCourseStatus;
use PHPUnit\Framework\TestCase;
class TabsBuilderTest extends TestCase
{

    public function testBuildGroupsRecordsIntoTabs(): void
    {
        $user = new \stdClass();

        $ci1 = new CourseInstance();
        $ci1->_setProperty('uid', 1);
        $ci1->setTitle('Course 1');
        $ci1->setLocation('loc1');
        $ci1->setStartDate(new DateTimeImmutable('2024-01-01'));
        $ci1->setEndDate(new DateTimeImmutable('2024-01-02'));

        $record1 = new UserCourseRecord();
        $record1->setCourseInstance($ci1);
        $record1->setStatus(UserCourseStatus::InProgress);
        $record1->setProgressPercent(50.0);
        $ci1->addUserCourseRecord($record1);

        $ci2 = new CourseInstance();
        $ci2->_setProperty('uid', 2);
        $ci2->setTitle('Course 2');
        $ci2->setLocation('loc2');
        $ci2->setStartDate(new DateTimeImmutable('2024-02-01'));
        $ci2->setEndDate(new DateTimeImmutable('2024-02-02'));

        $record2 = new UserCourseRecord();
        $record2->setCourseInstance($ci2);
        $record2->setStatus(UserCourseStatus::Validated);
        $record2->setProgressPercent(100.0);
        $ci2->addUserCourseRecord($record2);

        $repo = new class([$record1, $record2]) implements UserCourseRecordRepositoryInterface {
            public function __construct(private array $records) {}
            public function findByUuid(string $uuid): ?UserCourseRecord { return null; }
            public function findCompletedWithoutBadge(): array { return []; }
            public function findOneByUserAndCourse(int $userId, int $courseUid): ?UserCourseRecord { return null; }
            public function findByUser($user): array { return $this->records; }
        };

        $translator = new class implements GptTranslationServiceInterface {
            public function isEnabled(): bool { return true; }
            public function translate(string $key, array $arguments = [], ?string $extension = null): ?string { return $arguments['title'] ?? null; }
        };

        $builder = new TabsBuilder($repo, $translator);

        $cert = new class { public function getQrCodeUrl(): string { return 'cert'; } };

        $result = $builder->build($user, [2 => $cert]);

        $this->assertCount(1, $result['running']);
        $this->assertSame(1, $result['running'][0]['id']);
        $this->assertSame(50.0, $result['running'][0]['progressPercent']);

        $this->assertCount(1, $result['completed']);
        $this->assertSame('cert', $result['completed'][0]['certificateUrl']);
    }
}
}
