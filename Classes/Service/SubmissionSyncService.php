<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepository;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Ramsey\Uuid\Uuid;

final class SubmissionSyncService
{
    public function __construct(
        private readonly UserSubmissionRepository $submissionRepository,
        private readonly PersistenceManagerInterface $persistenceManager
    ) {
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
            $submission->setUpdatedAt(new \DateTimeImmutable());
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
