<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Domain\Model\RecognitionAward;

final class RecognitionAwardDtoAssembler
{
    /**
     * @return array<string,mixed>
     */
    public static function fromEntity(RecognitionAward $award): array
    {
        return [
            'id' => $award->getUid(),
            'type' => $award->getAwardType(),
            'typeKey' => $award->getAwardTypeKey(),
            'summary' => $award->getCriteriaSummary(),
            'summaryKey' => $award->getCriteriaSummaryKey(),
            'grantedAt' => $award->getGrantedAt()?->format(DATE_ATOM),
        ];
    }

    /**
     * @param iterable<RecognitionAward> $awards
     * @return array<int,array<string,mixed>>
     */
    public static function fromEntities(iterable $awards): array
    {
        $data = [];
        foreach ($awards as $award) {
            $data[] = self::fromEntity($award);
        }

        return $data;
    }
}
