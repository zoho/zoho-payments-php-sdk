<?php

declare(strict_types=1);

namespace Zoho\Payments\Auth;

final class OAuthToken implements \JsonSerializable
{
    private const REDACTED = '[REDACTED]';

    public readonly string $accessToken;
    public readonly int $expiresIn;

    public function __construct(string $accessToken, int $expiresIn)
    {
        if ($accessToken === '') {
            throw new \InvalidArgumentException('access_token must not be empty');
        }
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
    }

    public function __debugInfo(): array
    {
        return [
            'accessToken' => self::REDACTED,
            'expiresIn' => $this->expiresIn,
        ];
    }

    public function jsonSerialize(): array
    {
        return [
            'accessToken' => self::REDACTED,
            'expiresIn' => $this->expiresIn,
        ];
    }
}
