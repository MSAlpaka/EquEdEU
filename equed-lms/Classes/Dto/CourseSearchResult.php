<?php
declare(strict_types=1);

namespace Equed\EquedLms\Dto;

final class CourseSearchResult implements \JsonSerializable
{
    public function __construct(
        private readonly int $uid,
        private readonly string $title,
        private readonly string $description,
    ) {
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function jsonSerialize(): array
    {
        return [
            'uid' => $this->uid,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
