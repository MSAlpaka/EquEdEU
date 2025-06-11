<?php

declare(strict_types=1);

namespace Equed\EquedCore\Cache;

use DateInterval;
use DateTimeImmutable;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException as PsrInvalidArgumentException;

/**
 * Lightweight array based cache implementing PSR SimpleCache.
 */
class ArrayCache implements CacheInterface
{
    /** @var array<string, mixed> */
    private array $data = [];

    /** @var array<string, int> */
    private array $expirations = [];

    /** @throws PsrInvalidArgumentException */
    private function assertValidKey(string $key): void
    {
        if ($key === '') {
            throw new class ('Empty key') extends \InvalidArgumentException implements PsrInvalidArgumentException {
            };
        }
    }

    private function ttlToExpiration(null|int|DateInterval $ttl): ?int
    {
        if ($ttl instanceof DateInterval) {
            $start = new DateTimeImmutable('@0');
            $ttl = $start->add($ttl)->getTimestamp();
        }
        return is_int($ttl) ? time() + $ttl : null;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->assertValidKey($key);
        if (!$this->has($key)) {
            return $default;
        }
        return $this->data[$key];
    }

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $this->assertValidKey($key);
        $this->data[$key] = $value;
        $expiration = $this->ttlToExpiration($ttl);
        if ($expiration !== null) {
            $this->expirations[$key] = $expiration;
        } else {
            unset($this->expirations[$key]);
        }
        return true;
    }

    public function delete(string $key): bool
    {
        $this->assertValidKey($key);
        unset($this->data[$key], $this->expirations[$key]);
        return true;
    }

    public function clear(): bool
    {
        $this->data = [];
        $this->expirations = [];
        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get((string) $key, $default);
        }
        return $results;
    }

    /**
     * @phpstan-param iterable<string, mixed> $values
     * @param iterable $values Key-value pairs to store in the cache
     */
    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set((string) $key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete((string) $key);
        }
        return true;
    }

    public function has(string $key): bool
    {
        $this->assertValidKey($key);
        if (!array_key_exists($key, $this->data)) {
            return false;
        }
        if (isset($this->expirations[$key]) && $this->expirations[$key] < time()) {
            unset($this->data[$key], $this->expirations[$key]);
            return false;
        }
        return true;
    }
}
