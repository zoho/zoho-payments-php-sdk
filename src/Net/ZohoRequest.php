<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

/** @phpstan-type Headers array<string, list<string>> */
final class ZohoRequest
{
    public readonly RequestMethod $method;
    public readonly string $url;
    /** @var array<string, list<string>> */
    public readonly array $headers;
    public readonly ?string $body;
    public readonly ?float $timeout;

    /** @param array<string, list<string>> $headers */
    public function __construct(
        RequestMethod $method,
        string $url,
        array $headers,
        ?string $body,
        ?float $timeout,
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
        $this->timeout = $timeout;
    }

    public static function builder(): ZohoRequestBuilder
    {
        return new ZohoRequestBuilder();
    }
}
