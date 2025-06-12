<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserCourseRecord;

/**
 * Interface for user course record repository
 *
 * @method UserCourseRecord|null findByUid(int $uid)
 * @method UserCourseRecord|null findOneByUserAndCourseInstance(int $userId, int $courseInstanceId)
 * @method UserCourseRecord|null findLatestByUserAndInstance(\Equed\EquedLms\Domain\Model\FrontendUser $user, \Equed\EquedLms\Domain\Model\CourseInstance $instance)
 * @method UserCourseRecord[] findByInstructor(int $instructorId)
 * @method UserCourseRecord[] findByFeUser(int $feUserId)
 * @method UserCourseRecord[] findByUserId(int $userId)
 * @method UserCourseRecord[] findByUserAndCourseInstance(int $userId, int $courseInstanceId)
 * @method UserCourseRecord[] findByUserAndStatus(int $userId, string $status)
 * @method int countByStatus(string $status)
 * @method int countByUserId(int $userId)
 * @method int countByUserIdAndStatus(int $userId, string $status)
 * @method int countByUserAndInstanceAndStatus(int $userId, int $courseInstanceId, string $status)
 * @method int countByUserIdAndCourseProgram(int $userId, int $courseProgramId)
 * @method void add(UserCourseRecord $record)
 * @method void update(UserCourseRecord $record)
 */
interface UserCourseRecordRepositoryInterface
{
    public function findByUuid(string $uuid): ?UserCourseRecord;
}
