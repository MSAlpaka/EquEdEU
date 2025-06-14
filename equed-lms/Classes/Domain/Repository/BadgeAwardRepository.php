<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\BadgeAward;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\BadgeLevel;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for BadgeAward entities.
 *
 * @extends Repository<BadgeAward>
 */
final class BadgeAwardRepository extends Repository implements BadgeAwardRepositoryInterface
{
    /**
     * Find awards for a frontend user.
     *
     * @param int $feUserId
     * @return BadgeAward[]
     */
    public function findByFeUser(int $feUserId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('frontendUser', $feUserId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Add a course completion award.
     */
    public function addForCourse(int $userId, int $courseId, string $label): void
    {
        $award = new BadgeAward(BadgeLevel::Bronze);
        $user  = new FrontendUser();
        $user->_setProperty('uid', $userId);

        $award->setFrontendUser($user);
        $award->setBadgeType('course');
        $award->setBadgeCode((string)$courseId);
        $award->setDescriptionKey($label);

        parent::add($award);
    }

    /**
     * Add a learning path completion award.
     */
    public function addForLearningPath(int $userId, int $pathId, string $label): void
    {
        $award = new BadgeAward(BadgeLevel::Bronze);
        $user  = new FrontendUser();
        $user->_setProperty('uid', $userId);

        $award->setFrontendUser($user);
        $award->setBadgeType('learning_path');
        $award->setBadgeCode((string)$pathId);
        $award->setDescriptionKey($label);

        parent::add($award);
    }
}
