<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Interface for the LogService to decouple consumers from implementation.
 */
interface LogServiceInterface
{
    /**
     * Logs an informational message.
     *
     * @param array<string,mixed> $context
     */
    public function logInfo(string $message, array $context = []): void;

    /**
     * Logs a warning message.
     *
     * @param array<string,mixed> $context
     */
    public function logWarning(string $message, array $context = []): void;

    /**
     * Logs an error message.
     *
     * @param array<string,mixed> $context
     */
    public function logError(string $message, array $context = []): void;
}
