<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * Data Transfer Object for lessons.
 */
final class LessonDto implements \JsonSerializable
{
    /**
     * @param array<int,array<string,mixed>> $assets
     * @param array<int,array<string,mixed>> $content
     */
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly ?string $titleKey,
        private readonly ?string $updatedAt,
        private readonly ?int $courseId,
        private readonly array $assets,
        private readonly array $content,
        private readonly ?string $accessibilityNotes,
        private readonly ?string $mediaAltText,
        private readonly ?string $transcript,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function getAccessibilityNotes(): ?string
    {
        return $this->accessibilityNotes;
    }

    public function getMediaAltText(): ?string
    {
        return $this->mediaAltText;
    }

    public function getTranscript(): ?string
    {
        return $this->transcript;
    }

    /** @return array<int,array<string,mixed>> */
    public function getAssets(): array
    {
        return $this->assets;
    }

    /** @return array<int,array<string,mixed>> */
    public function getContent(): array
    {
        return $this->content;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'titleKey' => $this->titleKey,
            'updatedAt' => $this->updatedAt,
            'courseId' => $this->courseId,
            'assets' => $this->assets,
            'content' => $this->content,
            'accessibilityNotes' => $this->accessibilityNotes,
            'mediaAltText' => $this->mediaAltText,
            'transcript' => $this->transcript,
        ];
    }
}
