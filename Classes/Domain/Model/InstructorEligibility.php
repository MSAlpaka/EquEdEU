<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * InstructorEligibility
 *
 * Defines eligibility of an instructor for a given course program.
 */
final class InstructorEligibility extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $instructor = null;

    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;

    protected bool $eligible = false;

    protected ?string $reason = null;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getInstructor(): ?FrontendUser
    {
        return $this->instructor;
    }

    public function setInstructor(?FrontendUser $instructor): void
    {
        $this->instructor = $instructor;
    }

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function isEligible(): bool
    {
        return $this->eligible;
    }

    public function setEligible(bool $eligible): void
    {
        $this->eligible = $eligible;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
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
