<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Inject;
use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;

/**
 * Certificate
 *
 * Stores a generated certificate and its associations.
 */
final class Certificate extends AbstractEntity
{
    use PersistenceTrait;

    /** Receiving user */
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $feUser = null;

    /** Optional associated course */
    #[ManyToOne]
    #[Lazy]
    protected ?Course $course = null;

    /** Timestamp when certificate was submitted */
    protected ?DateTimeImmutable $submittedAt = null;

    /** Related course program */
    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;

    /** Date certificate was issued */
    protected DateTimeImmutable $issuedAt;

    /** Certificate number */
    protected string $certificateNumber = '';

    /** PDF or image file */
    #[Lazy]
    protected ?FileReference $file = null;

    /** Dispatch record */
    #[ManyToOne]
    #[Lazy]
    protected ?CertificateDispatch $certificateDispatch = null;

    /** Course certificate this record belongs to */
    #[ManyToOne]
    #[Lazy]
    protected ?CourseCertificate $courseCertificate = null;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->issuedAt = $now;
    }

    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getFeUser(): ?FrontendUser
    {
        return $this->feUser;
    }

    public function setFeUser(?FrontendUser $feUser): void
    {
        $this->feUser = $feUser;
    }

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    public function getIssuedAt(): DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(DateTimeImmutable $issuedAt): void
    {
        $this->issuedAt = $issuedAt;
    }

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function setCertificateNumber(string $certificateNumber): void
    {
        $this->certificateNumber = $certificateNumber;
    }

    public function getSubmittedAt(): ?DateTimeImmutable
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(?DateTimeImmutable $submittedAt): void
    {
        $this->submittedAt = $submittedAt;
    }

    public function getFile(): ?FileReference
    {
        return $this->file;
    }

    public function setFile(?FileReference $file): void
    {
        $this->file = $file;
    }

    public function getCertificateDispatch(): ?CertificateDispatch
    {
        return $this->certificateDispatch;
    }

    public function setCertificateDispatch(?CertificateDispatch $certificateDispatch): void
    {
        $this->certificateDispatch = $certificateDispatch;
    }

    public function getCourseCertificate(): ?CourseCertificate
    {
        return $this->courseCertificate;
    }

    public function setCourseCertificate(?CourseCertificate $courseCertificate): void
    {
        $this->courseCertificate = $courseCertificate;
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
