<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

final class ZohoRequestBuilder
{
    private ?RequestMethod $method = null;
    private ?string $url = null;
    /** @var array<string, list<string>> */
    private array $headers = [];
    private ?string $body = null;
    private ?float $timeout = null;

    public function method(RequestMethod $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    // Append a header value (allows multiple values per name).
    public function header(string $name, string $value): self
    {
        $this->headers[$name][] = $value;
        return $this;
    }

    // Replace any existing values for the header name.
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = [$value];
        return $this;
    }

    /** @param array<string, string> $headers */
    public function headers(array $headers): self
    {
        foreach ($headers as $k => $v) {
            $this->header($k, $v);
        }
        return $this;
    }

    public function body(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function timeout(?float $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function build(): ZohoRequest
    {
        if ($this->method === null) {
            throw new \InvalidArgumentException('method is required');
        }
        if ($this->url === null || $this->url === '') {
            throw new \InvalidArgumentException('url is required');
        }
        return new ZohoRequest(
            method: $this->method,
            url: $this->url,
            headers: $this->headers,
            body: $this->body,
            timeout: $this->timeout,
        );
    }
}
