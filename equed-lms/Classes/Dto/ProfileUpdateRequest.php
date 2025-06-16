<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Request DTO for updating user profiles.
 */
final class ProfileUpdateRequest
{
    /**
     * Allowed fields that can be updated via the API.
     */
    private const ALLOWED_FIELDS = ['name', 'email'];

    /**
     * @param array<string,string> $fields
     */
    public function __construct(private readonly array $fields)
    {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $body   = (array) $request->getParsedBody();
        $fields = [];
        foreach (self::ALLOWED_FIELDS as $field) {
            if (isset($body[$field]) && is_string($body[$field])) {
                $value = trim($body[$field]);
                if ($value !== '') {
                    $fields[$field] = $value;
                }
            }
        }

        if ($fields === []) {
            throw new InvalidArgumentException('No updateable fields provided');
        }

        return new self($fields);
    }

    /**
     * @return array<string,string>
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}

