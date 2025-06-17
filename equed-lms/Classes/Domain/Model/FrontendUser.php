<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser as ExtbaseFrontendUser;
use Equed\EquedLms\Domain\Model\TitleAwareGroupInterface;

final class FrontendUser extends ExtbaseFrontendUser
{
    /**
     * User name.
     */
    protected string $name = '';

    /**
     * List of user groups.
     *
     * @var array<int, TitleAwareGroupInterface>
     */
    protected array $usergroup = [];

    /**
     * API token assigned to the user
     *
     * @var string|null
     */
    protected ?string $apiToken = null;

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array<int, TitleAwareGroupInterface>
     */
    public function getUsergroup(): array
    {
        return $this->usergroup;
    }

    /**
     * @param array<int, TitleAwareGroupInterface> $usergroup
     */
    public function setUsergroup(array $usergroup): void
    {
        $this->usergroup = $usergroup;
    }
}
