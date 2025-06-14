<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\Dashboard\FilterMetadataProvider;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use PHPUnit\Framework\TestCase;

class FilterMetadataProviderTest extends TestCase
{

    public function testGetMetadataReturnsFields(): void
    {
        $ciRepo = new class implements CourseInstanceRepositoryInterface {
            public function findAllRequiringExternalExaminer(): array { return []; }
            public function findDistinctField(string $field): array { return match($field){
                'theme' => ['a'], 'language' => ['en'], 'eqfLevel' => [1], default => []}; }
        };
        $ucRepo = new class implements UserCourseRecordRepositoryInterface {
            public function findByUuid(string $uuid): ?UserCourseRecord { return null; }
            public function findCompletedWithoutBadge(): array { return []; }
            public function findOneByUserAndCourse(int $userId, int $courseUid): ?UserCourseRecord { return null; }
            public function findDistinctField(string $field): array { return ['none']; }
        };

        $provider = new FilterMetadataProvider($ciRepo, $ucRepo);

        $result = $provider->getMetadata();

        $this->assertSame(['a'], $result['theme']);
        $this->assertSame(['en'], $result['language']);
        $this->assertSame(['none'], $result['badgeStatus']);
        $this->assertSame([1], $result['eqfLevel']);
    }
}
