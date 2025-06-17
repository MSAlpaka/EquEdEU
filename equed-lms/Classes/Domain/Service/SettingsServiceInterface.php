<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Interface for retrieving extension settings.
 */
interface SettingsServiceInterface
{
    /**
     * Returns a setting value by key or default if not set.
     *
     * @param string $key Setting key
     * @param mixed $default Default value
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Returns all settings for the extension.
     *
     * @return array<string,mixed>
     */
    public function all(): array;
}
