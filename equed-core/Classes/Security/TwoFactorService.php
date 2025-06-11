<?php

declare(strict_types=1);

namespace Equed\EquedCore\Security;

class TwoFactorService
{
    public function generateCode(string $secret, ?int $timestamp = null): string
    {
        $timeSlice = (int) floor(($timestamp ?? time()) / 30);
        $secretKey = $this->base32Decode($secret);
        $binaryTime = pack('N*', 0) . pack('N*', $timeSlice);
        $hash = hash_hmac('sha1', $binaryTime, $secretKey, true);
        $offset = ord(substr($hash, -1)) & 0xf;
        $packed = unpack('N', substr($hash, $offset, 4));
        $int = is_array($packed) ? (int) $packed[1] : 0;
        $value = ($int & 0x7fffffff) % 1000000;
        return str_pad((string) $value, 6, '0', STR_PAD_LEFT);
    }

    public function verifyCode(string $secret, string $code, ?int $timestamp = null): bool
    {
        return hash_equals($this->generateCode($secret, $timestamp), $code);
    }

    private function base32Decode(string $b32): string
    {
        $b32 = strtoupper($b32);
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bitString = '';
        foreach (str_split($b32) as $char) {
            if ($char === '=') {
                break;
            }
            $pos = strpos($alphabet, $char);
            if ($pos === false) {
                continue;
            }
            $bitString .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }
        $binary = '';
        foreach (str_split($bitString, 8) as $byte) {
            if (strlen($byte) === 8) {
                $binary .= chr((int) bindec($byte));
            }
        }
        return $binary;
    }
}
