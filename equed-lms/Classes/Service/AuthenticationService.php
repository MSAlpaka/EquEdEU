<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\Core\Service\PasswordHasherInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\UserRepositoryInterface;
use Equed\EquedLms\Domain\Service\AuthenticationServiceInterface;
use Equed\EquedLms\Domain\Service\JwtServiceInterface;

final class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly JwtServiceInterface $jwtService,
    ) {
    }

    public function validateCredentials(string $email, string $password): ?FrontendUser
    {
        $user = $this->userRepository->findOneByEmail($email);
        if ($user === null || ! $this->passwordHasher->verify($password, $user->getPasswordHash())) {
            return null;
        }

        return $user;
    }

    public function getUserById(int $userId): ?FrontendUser
    {
        return $this->userRepository->findByUid($userId);
    }

    public function createToken(FrontendUser $user): string
    {
        $roles = array_map(
            static fn ($group) => $group->getUid(),
            $user->getUserGroups()->toArray(),
        );

        $payload = [
            'uid'   => $user->getUid(),
            'email' => $user->getEmail(),
            'roles' => $roles,
        ];

        return $this->jwtService->generateToken($payload);
    }
}
