<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * AccessLog
 *
 * Logs sanitized access events.
 */
final class AccessLog extends AbstractEntity
{
    use PersistenceTrait;

    /** Frontend user UID */
    protected int $feUser = 0;

    /** IP address */
    protected string $ipAddress = '';

    /** User agent string */
    protected string $userAgent = '';

    /** Event type */
    protected string $eventType = '';

    /** Event context */
    protected string $eventContext = '';

    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
    }


    public function getFeUser(): int
    {
        return $this->feUser;
    }

    public function setFeUser(int $feUser): void
    {
        $this->feUser = $feUser;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): void
    {
        $this->eventType = $eventType;
    }

    public function getEventContext(): string
    {
        return $this->eventContext;
    }

    public function setEventContext(string $eventContext): void
    {
        $this->eventContext = $eventContext;
    }

}
