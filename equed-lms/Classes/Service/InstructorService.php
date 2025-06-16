<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Service\InstructorServiceInterface;
use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Model\InstructorFeedback;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Repository\InstructorFeedbackRepositoryInterface;
use Equed\EquedLms\Enum\UserCourseStatus;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Service to retrieve instructors and check instructor-course assignments.
 */
final class InstructorService implements InstructorServiceInterface
{
    public function __construct(
        private readonly UserProfileRepositoryInterface   $userProfileRepository,
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
        private readonly InstructorFeedbackRepositoryInterface $feedbackRepository,
        private readonly PersistenceManagerInterface      $persistenceManager,
        private readonly ClockInterface                   $clock,
    ) {
    }

    /**
     * Retrieve all user profiles marked as instructors.
     *
     * @return UserProfile[]
     */
    public function getInstructors(): array
    {
        return $this->userProfileRepository->findByInstructorStatus(true);
    }

    /**
     * Check if a given instructor (by FE user UID) is assigned to a course instance.
     *
     * @param int $instructorFeUserId Frontend user UID of the instructor
     * @param int $courseInstanceId   UID of the course instance
     * @return bool True if assigned, false otherwise
     */
    public function isAssignedToCourse(int $instructorFeUserId, int $courseInstanceId): bool
    {
        $profile = $this->userProfileRepository->findByFeUser($instructorFeUserId);

        return $profile?->isAssignedToCourseInstance($courseInstanceId) ?? false;
    }

    /**
     * Mark a user course record as completed by the instructor if allowed.
     */
    public function completeCourse(int $recordId, int $instructorId): bool
    {
        $record = $this->recordRepository->findByUid($recordId);
        if ($record === null) {
            return false;
        }

        $instanceInstructor = $record->getCourseInstance()->getInstructor();
        if ($instanceInstructor === null || (int)$instanceInstructor->getUid() !== $instructorId) {
            return false;
        }

        if (! $record->isCompleted()) {
            $record->setStatus(UserCourseStatus::Passed);
            $record->setCompletedAt($this->clock->now());
            $this->recordRepository->update($record);
            $this->persistenceManager->persistAll();
        }

        return true;
    }

    /**
     * Store an evaluation note for a user course record.
     */
    public function uploadEvaluation(int $recordId, int $instructorId, string $note): bool
    {
        $record = $this->recordRepository->findByUid($recordId);
        if ($record === null) {
            return false;
        }

        $instanceInstructor = $record->getCourseInstance()->getInstructor();
        if ($instanceInstructor === null || (int)$instanceInstructor->getUid() !== $instructorId) {
            return false;
        }

        $feedback = new InstructorFeedback();
        $feedback->setUserCourseRecord($record);
        $feedback->setInstructor($instanceInstructor);
        $feedback->setComment($note);
        $feedback->setCreatedAt($this->clock->now());
        $feedback->setUpdatedAt($this->clock->now());

        $this->feedbackRepository->add($feedback);
        $this->persistenceManager->persistAll();

        return true;
    }
}
