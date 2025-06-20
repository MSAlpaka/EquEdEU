<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * PaymentLog
 *
 * Stores sanitized payment transactions.
 */
final class PaymentLog extends AbstractEntity
{
    protected string $uuid;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    /** Hash of the user identifier */
    protected string $userHash = '';

    /** Amount paid */
    protected string $amount = '';

    /** Payment method identifier */
    protected int $paymentMethod = 0;

    /** Hash of the external transaction id */
    protected string $transactionHash = '';

    /** Payment status */
    protected int $status = 0;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function initializeObject(): void
    {
        // if Clock or UUID generator are injected late
        if (empty($this->uuid)) {
            $this->uuid = $this->uuidGenerator->generate();
        }

        $now = $this->clock->now();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUserHash(): string
    {
        return $this->userHash;
    }

    public function setUserIdentifier(string|int $userIdentifier): void
    {
        $this->userHash = sha1((string) $userIdentifier);
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function getPaymentMethod(): int
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(int $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getTransactionHash(): string
    {
        return $this->transactionHash;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionHash = sha1($transactionId);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
