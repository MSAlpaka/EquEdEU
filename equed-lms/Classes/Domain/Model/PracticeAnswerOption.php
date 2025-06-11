<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\UuidGeneratorInterface;
use Equed\Core\Service\ClockInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for practice answer options.
 */
final class PracticeAnswerOption extends AbstractEntity
{
    /**
     * UUID of the answer option.
     */
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    /**
     * The question this answer option belongs to.
     */
    #[ManyToOne]
    #[Lazy]
    protected ?PracticeQuestion $practiceQuestion = null;

    /**
     * The answer text.
     */
    protected string $text = '';

    /**
     * Indicates if this option is correct.
     */
    protected bool $isCorrect = false;

    /**
     * Explanation text for this option.
     */
    protected ?string $explanationText = null;

    /**
     * Language code for text.
     */
    protected string $lang = 'en';

    /**
     * Who generated this option (e.g. 'human', 'gpt').
     */
    protected ?string $generatedBy = null;

    /**
     * Version of GPT that generated this option.
     */
    protected ?string $gptVersion = null;

    /**
     * Creation timestamp.
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp.
     */
    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }

        if (!isset($this->createdAt)) {
            $now = $this->clock->now();
            $this->createdAt = $now;
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
     * Gets the practice question.
     */
    public function getPracticeQuestion(): ?PracticeQuestion
    {
        return $this->practiceQuestion;
    }

    /**
     * Sets the practice question.
     */
    public function setPracticeQuestion(?PracticeQuestion $practiceQuestion): void
    {
        $this->practiceQuestion = $practiceQuestion;
    }

    /**
     * Gets the answer text.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the answer text.
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Checks if this option is correct.
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * Sets whether this option is correct.
     */
    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }

    /**
     * Gets the explanation text.
     */
    public function getExplanationText(): ?string
    {
        return $this->explanationText;
    }

    /**
     * Sets the explanation text.
     */
    public function setExplanationText(?string $explanationText): void
    {
        $this->explanationText = $explanationText;
    }

    /**
     * Gets the language code.
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * Sets the language code.
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Gets who generated this option.
     */
    public function getGeneratedBy(): ?string
    {
        return $this->generatedBy;
    }

    /**
     * Sets who generated this option.
     */
    public function setGeneratedBy(?string $generatedBy): void
    {
        $this->generatedBy = $generatedBy;
    }

    /**
     * Gets the GPT version used.
     */
    public function getGptVersion(): ?string
    {
        return $this->gptVersion;
    }

    /**
     * Sets the GPT version used.
     */
    public function setGptVersion(?string $gptVersion): void
    {
        $this->gptVersion = $gptVersion;
    }

    /**
     * Gets the creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
