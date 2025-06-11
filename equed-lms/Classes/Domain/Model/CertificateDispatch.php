<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\CourseInstance;

/**
 * CertificateDispatch
 *
 * Represents a dispatch record for certificates, including delivery details.
 */
final class CertificateDispatch extends AbstractEntity
{
    /**
     * Unique identifier
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Human readable title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * User who receives the certificate
     */
    #[ManyToOne]
    protected ?FrontendUser $feUser = null;

    /**
     * Course instance this dispatch belongs to
     */
    #[ManyToOne]
    protected ?CourseInstance $courseInstance = null;

    /**
     * Delivery method like "pdf" or "post"
     *
     * @var string
     */
    protected string $deliveryMethod = 'pdf';

    /**
     * URL for QR code embedded in the certificate
     *
     * @var string
     */
    protected string $qrCodeUrl = '';

    /**
     * PDF file reference
     */
    protected ?FileReference $pdf = null;

    /**
     * Creation timestamp
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $now = new DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getFeUser(): ?FrontendUser
    {
        return $this->feUser;
    }

    public function setFeUser(?FrontendUser $feUser): void
    {
        $this->feUser = $feUser;
    }

    public function getCourseInstance(): ?CourseInstance
    {
        return $this->courseInstance;
    }

    public function setCourseInstance(?CourseInstance $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(string $deliveryMethod): void
    {
        $this->deliveryMethod = $deliveryMethod;
    }

    public function getQrCodeUrl(): string
    {
        return $this->qrCodeUrl;
    }

    public function setQrCodeUrl(string $qrCodeUrl): void
    {
        $this->qrCodeUrl = $qrCodeUrl;
    }

    public function getPdf(): ?FileReference
    {
        return $this->pdf;
    }

    public function setPdf(?FileReference $pdf): void
    {
        $this->pdf = $pdf;
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
