<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\FrontendUserAccountRepositoryInterface;
use Equed\EquedLms\Application\Assembler\UserProfileDtoAssembler;
use Equed\EquedLms\Application\Dto\UserProfileDto;
use Equed\EquedLms\Domain\Service\UserAccountServiceInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\ProfileUpdateRequest;

/**
 * Default implementation for retrieving and updating frontend user profiles.
 */
final class UserAccountService implements UserAccountServiceInterface
{
    public function __construct(
        private readonly FrontendUserAccountRepositoryInterface $repository,
        private readonly ClockInterface $clock
    ) {
    }

    public function getProfile(int $userId): ?UserProfileDto
    {
        $profile = $this->repository->fetchProfile($userId);

        return $profile === null ? null : UserProfileDtoAssembler::fromArray($profile);
    }

    public function updateProfile(int $userId, ProfileUpdateRequest $request): void
    {
        $fields          = $request->getFields();
        $fields['tstamp'] = $this->clock->now()->getTimestamp();
        $this->repository->updateProfile($userId, $fields);
    }
}

