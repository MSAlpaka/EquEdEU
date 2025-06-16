<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Domain\Model\FrontendUser;
/**
 * CourseAccessMap
 *
 * Maps frontend users to course programs they have access to, with reasons.
 */
final class CourseAccessMap extends AbstractEntity
{
    /**
     * Unique identifier
     *
     * @var string
     */
    private string $uuid;
     * User who was granted access
    #[ManyToOne]
    private ?FrontendUser $feUser = null;
     * Course program that can be accessed
    private ?CourseProgram $courseProgram = null;
     * Why the user was granted access
    private string $grantReason = '';
     * Timestamp when access was granted
    private ?DateTimeImmutable $grantedAt = null;
     * Creation timestamp
    private DateTimeImmutable $createdAt;
     * Last update timestamp
    private DateTimeImmutable $updatedAt;
    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }
    public function initializeObject(): void
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
    public function getUuid(): string
        return $this->uuid;
    public function getFeUser(): ?FrontendUser
        return $this->feUser;
    public function setFeUser(?FrontendUser $feUser): void
        $this->feUser = $feUser;
    public function getCourseProgram(): ?CourseProgram
        return $this->courseProgram;
    public function setCourseProgram(?CourseProgram $courseProgram): void
        $this->courseProgram = $courseProgram;
    public function getGrantReason(): string
        return $this->grantReason;
    public function setGrantReason(string $grantReason): void
        $this->grantReason = $grantReason;
    public function getGrantedAt(): ?DateTimeImmutable
        return $this->grantedAt;
    public function setGrantedAt(?DateTimeImmutable $grantedAt): void
        $this->grantedAt = $grantedAt;
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
