<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Represents a user's request to book a course program.
 */
final class CourseBookingRequest extends AbstractEntity
{
    /** @var string */
    protected string $uuid;
    #[ManyToOne]
    protected ?FrontendUser $feUser = null;
    protected ?CourseProgram $courseProgram = null;
    /** @var string Preferred region for the course booking */
    protected string $preferredRegion = '';
    /** @var string Optional note provided by the user */
    protected string $note = '';
    /** @var DateTimeImmutable|null Timestamp when the request was made */
    protected ?DateTimeImmutable $requestedAt = null;
    /** @var DateTimeImmutable */
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }
    public function initializeObject(): void
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
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
    public function getPreferredRegion(): string
        return $this->preferredRegion;
    public function setPreferredRegion(string $preferredRegion): void
        $this->preferredRegion = $preferredRegion;
    public function getNote(): string
        return $this->note;
    public function setNote(string $note): void
        $this->note = $note;
    public function getRequestedAt(): ?DateTimeImmutable
        return $this->requestedAt;
    public function setRequestedAt(?DateTimeImmutable $requestedAt): void
        $this->requestedAt = $requestedAt;
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
