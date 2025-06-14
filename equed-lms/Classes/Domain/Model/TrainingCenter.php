<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for training centers.
 */
final class TrainingCenter extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    protected string $name = '';

    protected string $centerId = '';

    protected ?string $nameKey = null;

    protected ?string $description = null;

    protected ?string $descriptionKey = null;

    protected ?string $address = null;

    protected ?string $region = null;

    protected string $email = '';

    protected ?string $phone = null;

    protected ?string $website = null;

    protected ?DateTimeImmutable $certifiedUntil = null;

    protected string $status = 'active';

    protected string $country = '';

    protected ?string $zip = null;

    protected ?string $city = null;

    protected ?string $street = null;

    protected ?float $latitude = null;

    protected ?float $longitude = null;

    protected bool $isVisibleInDirectory = false;

    protected bool $isApprovedBySc = false;

    /**
     * @var ObjectStorage<CourseProgram>
     */
    protected ObjectStorage $allowedPrograms;

    /**
     * @var ObjectStorage<FrontendUser>
     */
    protected ObjectStorage $instructors;

    #[ManyToOne]
    #[Lazy]
    #[Cascade('remove')]
    protected ?FileReference $logo = null;

    protected LanguageCode $lang = LanguageCode::EN;

    protected bool $isArchived = false;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->allowedPrograms = new ObjectStorage();
        $this->instructors = new ObjectStorage();
    }

    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
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

    /**
     * Gets the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCenterId(): string
    {
        return $this->centerId;
    }

    public function setCenterId(string $centerId): void
    {
        $this->centerId = $centerId;
    }

    /**
     * Gets the translation key for the name.
     */
    public function getNameKey(): ?string
    {
        return $this->nameKey;
    }

    /**
     * Sets the translation key for the name.
     *
     * @param string|null $nameKey
     */
    public function setNameKey(?string $nameKey): void
    {
        $this->nameKey = $nameKey;
    }

    /**
     * Gets the description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets the translation key for the description.
     */
    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    /**
     * Sets the translation key for the description.
     *
     * @param string|null $descriptionKey
     */
    public function setDescriptionKey(?string $descriptionKey): void
    {
        $this->descriptionKey = $descriptionKey;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * Gets the email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the email.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets the phone number.
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Sets the phone number.
     *
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getCertifiedUntil(): ?DateTimeImmutable
    {
        return $this->certifiedUntil;
    }

    public function setCertifiedUntil(?DateTimeImmutable $certifiedUntil): void
    {
        $this->certifiedUntil = $certifiedUntil;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets the country code.
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Sets the country code.
     *
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Gets the ZIP code.
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * Sets the ZIP code.
     *
     * @param string|null $zip
     */
    public function setZip(?string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * Gets the city.
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets the city.
     *
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * Gets the street address.
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Sets the street address.
     *
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * Gets the latitude.
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude.
     *
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Gets the longitude.
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude.
     *
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Checks if visible in directory.
     */
    public function isVisibleInDirectory(): bool
    {
        return $this->isVisibleInDirectory;
    }

    /**
     * Sets visibility in directory.
     *
     * @param bool $isVisibleInDirectory
     */
    public function setIsVisibleInDirectory(bool $isVisibleInDirectory): void
    {
        $this->isVisibleInDirectory = $isVisibleInDirectory;
    }

    /**
     * Checks if approved by service center.
     */
    public function isApprovedBySc(): bool
    {
        return $this->isApprovedBySc;
    }

    /**
     * Sets approval by service center.
     *
     * @param bool $isApprovedBySc
     */
    public function setIsApprovedBySc(bool $isApprovedBySc): void
    {
        $this->isApprovedBySc = $isApprovedBySc;
    }

    /**
     * @return ObjectStorage<CourseProgram>
     */
    public function getAllowedPrograms(): ObjectStorage
    {
        return $this->allowedPrograms;
    }

    public function addAllowedProgram(CourseProgram $program): void
    {
        if (!$this->allowedPrograms->contains($program)) {
            $this->allowedPrograms->attach($program);
        }
    }

    public function removeAllowedProgram(CourseProgram $program): void
    {
        if ($this->allowedPrograms->contains($program)) {
            $this->allowedPrograms->detach($program);
        }
    }

    /**
     * @return ObjectStorage<FrontendUser>
     */
    public function getInstructors(): ObjectStorage
    {
        return $this->instructors;
    }

    public function addInstructor(FrontendUser $user): void
    {
        if (!$this->instructors->contains($user)) {
            $this->instructors->attach($user);
        }
    }

    public function removeInstructor(FrontendUser $user): void
    {
        if ($this->instructors->contains($user)) {
            $this->instructors->detach($user);
        }
    }

    /**
     * Gets the logo file.
     *
     * @return FileReference|null
     */
    public function getLogo(): ?FileReference
    {
        return $this->logo;
    }

    /**
     * Sets the logo file.
     *
     * @param FileReference|null $logo
     */
    public function setLogo(?FileReference $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * Gets the language code.
     */
    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    /**
     * Sets the language code.
     *
     * @param LanguageCode $lang
     */
    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Checks if archived.
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * Sets archived state.
     *
     * @param bool $isArchived
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    /**
     * Gets creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets creation timestamp.
     *
     * @param DateTimeImmutable $createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets last update timestamp.
     *
     * @param DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
