<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Ramsey\Uuid\Uuid;
use Equed\EquedLms\Domain\Service\ClockInterface;

final class SubmissionSyncService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly ClockInterface $clock
    ) {
    }

    /**
     * Export all submissions for the given frontend user.
     *
     * @param int $userId Frontend user identifier
     * @return array<int, array<string, mixed>>
     */
    public function exportForApp(int $userId): array
    {
        $submissions = $this->submissionRepository->findByFeUser($userId);
        $result      = [];

        foreach ($submissions as $submission) {
            $result[] = $this->push($submission);
        }

        return $result;
    }

    /**
     * Import a submission payload coming from the app.
     *
     * @param array<string, mixed> $payload
     */
    public function importFromApp(array $payload): UserSubmission
    {
        $data = $payload['submission'] ?? $payload;

        if (!isset($data['userId']) && isset($payload['userId'])) {
            $data['userId'] = (int) $payload['userId'];
        }

        return $this->pull($data);
    }

    /**
     * Export a submission into an associative array for API transfer.
     *
     * @return array{uuid:string,userId:int,course:int,status:string,score:float|null,updatedAt:?string,gptFeedback:string|null}
     */
    public function push(UserSubmission $submission): array
    {
        return [
            'uuid'         => $submission->getUuid(),
            'userId'       => $submission->getUser(),
            'course'       => $submission->getCourseInstance(),
            'status'       => $submission->getStatus()->value,
            'score'        => $submission->getScore(),
            'updatedAt'    => $submission->getUpdatedAt()?->format(DATE_ATOM),
            'gptFeedback'  => $submission->getGptFeedback(),
        ];
    }

    /**
     * Update or create a submission entity from API payload.
     *
     * @param array{uuid:string,userId:int,course:int,status:string,score?:float,updatedAt?:string,gptFeedback?:string} $data
     */
    public function pull(array $data): UserSubmission
    {
        $submission = $this->submissionRepository->findByUuid($data['uuid']) ?? new UserSubmission();

        if ($submission->getUuid() === null) {
            $submission->setUuid(Uuid::uuid4()->toString());
        }

        $remoteUpdated = new \DateTimeImmutable($data['updatedAt'] ?? 'now');
        $localUpdated = $submission->getUpdatedAt();

        if (!$localUpdated || $remoteUpdated > $localUpdated) {
            $submission->setUser((int) $data['userId']);
            $submission->setCourseInstance((int) $data['course']);
            $submission->setStatus($data['status']);
            $submission->setScore((float) ($data['score'] ?? 0));
            $submission->setGptFeedback((string) ($data['gptFeedback'] ?? ''));
            $submission->setUpdatedAt($this->clock->now());
        }

        if ($submission->getUid() === null) {
            $this->submissionRepository->add($submission);
        } else {
            $this->submissionRepository->update($submission);
        }

        $this->persistenceManager->persistAll();

        return $submission;
    }
}
