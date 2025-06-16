<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model\Traits;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
trait PersistenceTrait
{
    protected string $uuid = '';
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    protected function initializePersistenceTrait(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
    }
    public function getUuid(): string
        return $this->uuid;
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
