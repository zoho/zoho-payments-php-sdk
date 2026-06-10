<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

final class ZohoResponse
{
    public readonly int $statusCode;
    /** @var array<string, list<string>> */
    public readonly array $headers;
    public readonly ?string $body;

    /** @param array<string, list<string>> $headers */
    public function __construct(int $statusCode, array $headers, ?string $body)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }
}
