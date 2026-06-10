<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

final class ApiResponse
{
    public readonly int $statusCode;
    /** @var array<string, mixed> */
    public readonly array $body;

    /** @param array<string, mixed>|null $body */
    public function __construct(int $statusCode, ?array $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body ?? [];
    }

    public function getCodeString(): ?string
    {
        $code = $this->body['code'] ?? null;
        if ($code === null) {
            return null;
        }
        return is_scalar($code) ? (string) $code : null;
    }

    public function getMessage(): ?string
    {
        $msg = $this->body['message'] ?? null;
        if ($msg === null) {
            return null;
        }
        return is_scalar($msg) ? (string) $msg : null;
    }

    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}
