<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
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
        private readonly ConnectionPool $connectionPool,
        private readonly ClockInterface $clock
    ) {
    }

    public function getProfile(int $userId): ?UserProfileDto
    {
        $qb = $this->getQueryBuilder('fe_users');
        $qb->select('uid', 'username', 'name', 'email', 'usergroup')
            ->from('fe_users')
            ->where(
                $qb->expr()->eq('uid', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            );

        $profile = $qb->executeQuery()->fetchAssociative();

        return $profile === false ? null : UserProfileDtoAssembler::fromArray($profile);
    }

    public function updateProfile(int $userId, ProfileUpdateRequest $request): void
    {
        $fields          = $request->getFields();
        $fields['tstamp'] = $this->clock->now()->getTimestamp();
        $connection = $this->connectionPool->getConnectionForTable('fe_users');
        $connection->update('fe_users', $fields, ['uid' => $userId]);
    }

    private function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}

