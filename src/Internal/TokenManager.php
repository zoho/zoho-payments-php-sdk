<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

/** Holds the current OAuth access token; updateToken() rotates it (no locking — PHP is shared-nothing per request). */
final class TokenManager
{
    private const REDACTED = '[REDACTED]';

    private string $accessToken;

    public function __construct(string $accessToken)
    {
        if ($accessToken === '') {
            throw new \InvalidArgumentException('access_token must not be empty');
        }
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function updateToken(string $newAccessToken): void
    {
        if ($newAccessToken === '') {
            throw new \InvalidArgumentException('new_access_token must not be empty');
        }
        $this->accessToken = $newAccessToken;
    }

    /** @return array<string, mixed> */
    public function __debugInfo(): array
    {
        return ['accessToken' => self::REDACTED];
    }
}
