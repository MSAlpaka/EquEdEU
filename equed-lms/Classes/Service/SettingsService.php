<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use Equed\EquedLms\Domain\Service\SettingsServiceInterface;

/**
 * Service to retrieve extension settings.
 */
final class SettingsService implements SettingsServiceInterface
{
    private readonly array $settings;
    private readonly string $extensionKey;

    public function __construct(
        ExtensionConfiguration $extensionConfiguration,
        string $extensionKey = 'equed_lms'
    ) {
        $this->extensionKey = $extensionKey;
        $this->settings = $extensionConfiguration->get($extensionKey) ?? [];
    }

    /**
     * Returns a setting value by key or default if not set.
     *
     * @param string $key     Setting key
     * @param mixed  $default Default value
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Returns all settings for the extension.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->settings;
    }
}
