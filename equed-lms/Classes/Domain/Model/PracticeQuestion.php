<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Domain model for practice questions.
 */
final class PracticeQuestion extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?PracticeTest $practiceTest = null;
    protected string $questionText = '';
    /**
     * ENUM: freitext, mc, multi, truefalse, gap.
     */
    protected string $questionType = 'freitext';
     * Expected answer text for freitext questions.
    protected ?string $expectedAnswerText = null;
     * Source of generation (e.g., 'human', 'gpt').
    protected ?string $generatedBy = null;
     * Version of GPT or source, e.g. 'GPT-4-Turbo 2024-04'.
    protected ?string $gptVersion = null;
     * Internal glossary key for linking.
    protected ?string $glossaryKey = null;
     * Language code: en, de, fr, es, sw.
    protected LanguageCode $lang = LanguageCode::EN;
     * Optional difficulty or weight.
    protected ?string $difficulty = null;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
     * Initializes UUID and timestamps.
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        if (!isset($this->createdAt)) {
            $now = new DateTimeImmutable();
            $this->createdAt = $now;
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the associated practice test.
    public function getPracticeTest(): ?PracticeTest
        return $this->practiceTest;
     * Sets the associated practice test.
     *
     * @param PracticeTest|null $practiceTest
    public function setPracticeTest(?PracticeTest $practiceTest): void
        $this->practiceTest = $practiceTest;
     * Gets the question text.
    public function getQuestionText(): string
        return $this->questionText;
     * Sets the question text.
    public function setQuestionText(string $questionText): void
        $this->questionText = $questionText;
     * Gets the question type.
    public function getQuestionType(): string
        return $this->questionType;
     * Sets the question type.
    public function setQuestionType(string $questionType): void
        $this->questionType = $questionType;
     * Gets the expected answer text.
    public function getExpectedAnswerText(): ?string
        return $this->expectedAnswerText;
     * Sets the expected answer text.
    public function setExpectedAnswerText(?string $expectedAnswerText): void
        $this->expectedAnswerText = $expectedAnswerText;
     * Gets the generator source.
    public function getGeneratedBy(): ?string
        return $this->generatedBy;
     * Sets the generator source.
    public function setGeneratedBy(?string $generatedBy): void
        $this->generatedBy = $generatedBy;
     * Gets the GPT version.
    public function getGptVersion(): ?string
        return $this->gptVersion;
     * Sets the GPT version.
    public function setGptVersion(?string $gptVersion): void
        $this->gptVersion = $gptVersion;
     * Gets the glossary key.
    public function getGlossaryKey(): ?string
        return $this->glossaryKey;
     * Sets the glossary key.
    public function setGlossaryKey(?string $glossaryKey): void
        $this->glossaryKey = $glossaryKey;
     * Gets the language code.
    public function getLang(): LanguageCode
        return $this->lang;
     * Sets the language code.
    public function setLang(LanguageCode $lang): void
        $this->lang = $lang;
     * Gets the difficulty.
    public function getDifficulty(): ?string
        return $this->difficulty;
     * Sets the difficulty.
    public function setDifficulty(?string $difficulty): void
        $this->difficulty = $difficulty;
     * Gets the creation time.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets the creation time.
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets the last update time.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets the last update time.
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
