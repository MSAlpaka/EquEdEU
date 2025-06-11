<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Psr\Log\LoggerInterface;

/**
 * Service for application logging.
 *
 * Context arrays are sanitized before being handed to the underlying logger
 * to avoid leaking personal identifiers such as user IDs or email addresses.
 */
final class LogService
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Logs an informational message.
     *
     * @param string               $message The log message
     * @param array<string,mixed>  $context Additional context data. Personal
     *                                     identifiers will be hashed.
     */
    public function logInfo(string $message, array $context = []): void
    {
        $this->logger->info($message, $this->sanitizeContext($context));
    }

    /**
     * Logs a warning message.
     *
     * @param string               $message The log message
     * @param array<string,mixed>  $context Additional context data. Personal
     *                                     identifiers will be hashed.
     */
    public function logWarning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $this->sanitizeContext($context));
    }

    /**
     * Logs an error message.
     *
     * @param string               $message The log message
     * @param array<string,mixed>  $context Additional context data. Personal
     *                                     identifiers will be hashed.
     */
    public function logError(string $message, array $context = []): void
    {
        $this->logger->error($message, $this->sanitizeContext($context));
    }

    /**
     * Removes or hashes personal information from the context array.
     *
     * @param array<string,mixed> $context
     * @return array<string,mixed>
     */
    private function sanitizeContext(array $context): array
    {
        $personalKeys = [
            'user',
            'userId',
            'studentUser',
            'instructor',
            'instructorId',
            'instructors',
            'email',
            'emailAddress',
        ];

        foreach ($context as $key => $value) {
            foreach ($personalKeys as $pattern) {
                if (stripos((string) $key, $pattern) !== false) {
                    if (is_array($value)) {
                        $context[$key] = array_map(
                            static fn ($v) => sha1((string) $v),
                            (array) $value
                        );
                    } else {
                        $context[$key] = sha1((string) $value);
                    }
                    continue 2;
                }
            }

            if (is_array($value)) {
                $context[$key] = $this->sanitizeContext($value);
            }
        }

        return $context;
    }
}
