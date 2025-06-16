<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\UserProfileDto;

final class UserProfileDtoAssembler
{
    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): UserProfileDto
    {
        $roles = array_filter(
            array_map('intval', explode(',', (string)($data['usergroup'] ?? '')))
        );

        return new UserProfileDto(
            (int)$data['uid'],
            (string)($data['name'] ?? ''),
            (string)($data['email'] ?? ''),
            $roles,
            trim((string)($data['name'] ?? '')) !== ''
        );
    }
}

