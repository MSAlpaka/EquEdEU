<?php
declare(strict_types=1);

namespace Equed\EquedLms\Dto;

final class GlossarySearchResult implements \JsonSerializable
{
    public function __construct(
        private readonly int $uid,
        private readonly string $term,
        private readonly string $definition,
    ) {
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }

    public function jsonSerialize(): array
    {
        return [
            'uid' => $this->uid,
            'term' => $this->term,
            'definition' => $this->definition,
        ];
    }
}
