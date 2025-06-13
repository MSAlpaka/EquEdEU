<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

interface UserCourseRecordFactoryInterface
{
    public function createForUserAndInstance(int $userId, CourseInstance $instance): UserCourseRecord;
}
