<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

final class DefaultUserCourseRecordFactory implements UserCourseRecordFactoryInterface
{
    public function __construct(private readonly FrontendUserFactoryInterface $frontendUserFactory)
    {
    }

    public function createForUserAndInstance(int $userId, CourseInstance $instance): UserCourseRecord
    {
        $record = new UserCourseRecord();
        $record->setUser($this->frontendUserFactory->createWithUid($userId));
        $record->setCourseInstance($instance);

        return $record;
    }
}
