<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Ramsey\Uuid\Uuid;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Enum\LanguageCode;
use Equed\EquedLms\Dto\SyncRequest;

final class SyncService
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $profileRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly ClockInterface $clock,
        private readonly LogService $logService
    ) {
    }

    /**
     * Returns profile data for the given user in the app format.
     */
    public function exportProfile(int $userId): array
    {
        $profile = $this->profileRepository->findByUserId($userId);
        if ($profile === null) {
            throw new \InvalidArgumentException('Profile not found');
        }

        return $this->pushToApp($profile);
    }

    /**
     * Convert a user profile into the array structure used by the app.
     *
     * @param UserProfile $profile Profile entity
     * @return array<string, mixed> Serializable representation
     */
    public function pushToApp(UserProfile $profile): array
    {
        return [
            'userId'      => $profile->getFeUser(),
            'uuid'        => $profile->getUuid(),
            'displayName' => $profile->getDisplayName(),
            'language'    => $profile->getLanguage()->value,
            'country'     => $profile->getCountry(),
            'updatedAt'   => $profile->getUpdatedAt()?->format(DATE_ATOM),
        ];
    }

    /**
     * Merge profile data coming from the app.
     */
    public function pullFromApp(SyncRequest $request): UserProfile
    {
        $data = $request->getPayload();
        $userId = $request->getUserId();
        $profile = $this->profileRepository->findByUserId($userId);
        if ($profile === null) {
            $profile = new UserProfile();
            $profile->setUpdatedAt($this->clock->now());
        }

        // Set user reference
        $profile->setFeUser($userId);

        // UUID handling
        if (method_exists($profile, 'setUuid') && empty($profile->getUuid())) {
            $profile->setUuid(Uuid::uuid4()->toString());
        }

        // Conflict resolution via updatedAt timestamp
        if (isset($data['updatedAt'])) {
            try {
                $remoteUpdated = new \DateTimeImmutable($data['updatedAt']);
            } catch (\Exception $e) {
                $this->logService->logWarning(
                    'Invalid timestamp for profile sync',
                    ['value' => $data['updatedAt'], 'userId' => $userId]
                );
                $remoteUpdated = null;
            }
        } else {
            $remoteUpdated = null;
        }
        $localUpdated = $profile->getUpdatedAt();

        if ($remoteUpdated && (!$localUpdated || $remoteUpdated > $localUpdated)) {
            if (isset($data['displayName'])) {
                $profile->setDisplayName((string) $data['displayName']);
            }
            if (isset($data['language'])) {
                $profile->setLanguage(LanguageCode::from((string) $data['language']));
            }
            if (isset($data['country'])) {
                $profile->setCountry((string) $data['country']);
            }
            $profile->setUpdatedAt($this->clock->now());
        }

        if ($profile->getUid() === null) {
            $this->profileRepository->add($profile);
        } else {
            $this->profileRepository->update($profile);
        }

        $this->persistenceManager->persistAll();

        return $profile;
    }
}
