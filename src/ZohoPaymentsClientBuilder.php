<?php

declare(strict_types=1);

namespace Zoho\Payments;

use Zoho\Payments\Auth\OAuthToken;
use Zoho\Payments\Internal\Defaults;
use Zoho\Payments\Internal\TokenManager;
use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Net\DefaultHttpClient;
use Zoho\Payments\Net\HttpClientInterface;

/** Single-use fluent builder for ZohoPaymentsClient; required fields are validated in build(), and the builder cannot be reused after build(). */
final class ZohoPaymentsClientBuilder
{
    private const RESERVED_HEADERS = [
        'authorization',
        'user-agent',
        'accept',
        'content-type',
        'content-length',
        'host',
    ];

    private ?string $accountId = null;
    private ?Edition $edition = null;
    private ?string $accessToken = null;
    private ?HttpClientInterface $httpClient = null;
    private ?float $connectTimeout = null;
    private ?float $requestTimeout = null;
    /** @var array<string, string> */
    private array $defaultHeaders = [];
    private bool $consumed = false;

    public function accountId(string $accountId): self
    {
        $this->accountId = $accountId;
        return $this;
    }

    public function edition(Edition $edition): self
    {
        $this->edition = $edition;
        return $this;
    }

    /** @param string|OAuthToken $token */
    public function oauthToken($token): self
    {
        if ($token instanceof OAuthToken) {
            $this->accessToken = $token->accessToken;
        } elseif (is_string($token)) {
            $this->accessToken = $token;
        } else {
            throw new \InvalidArgumentException('oauthToken must be a string or OAuthToken');
        }
        return $this;
    }

    // Custom HTTP transport; cannot be combined with connectTimeout() — a custom transport controls its own connection lifecycle.
    public function httpClient(HttpClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    // TCP connect timeout in seconds (default: 30); only applies to the default transport.
    public function connectTimeout(float $seconds): self
    {
        $this->connectTimeout = $seconds;
        return $this;
    }

    // Per-request read timeout in seconds (default: 60).
    public function requestTimeout(float $seconds): self
    {
        $this->requestTimeout = $seconds;
        return $this;
    }

    // Adds a default header sent with every request; SDK-managed headers (Authorization, User-Agent, Accept, Content-Type, Content-Length, Host) are rejected.
    public function addDefaultHeader(string $name, string $value): self
    {
        if ($name === '') {
            throw new \InvalidArgumentException('header name must not be empty');
        }
        if (in_array(strtolower($name), self::RESERVED_HEADERS, true)) {
            throw new \InvalidArgumentException(sprintf(
                "header '%s' is managed by the SDK and cannot be overridden",
                $name,
            ));
        }
        $this->defaultHeaders[$name] = $value;
        return $this;
    }

    public function build(): ZohoPaymentsClient
    {
        if ($this->consumed) {
            throw new \LogicException('Builder has already been consumed');
        }
        $this->consumed = true;

        if ($this->accountId === null || $this->accountId === '') {
            throw new \InvalidArgumentException('accountId is required');
        }
        if ($this->edition === null) {
            throw new \InvalidArgumentException('edition is required');
        }
        if ($this->accessToken === null || $this->accessToken === '') {
            throw new \InvalidArgumentException('oauthToken is required');
        }

        if ($this->httpClient !== null && $this->connectTimeout !== null) {
            throw new \InvalidArgumentException(
                'connectTimeout and a custom httpClient are mutually exclusive',
            );
        }

        $transport = $this->httpClient ?? new DefaultHttpClient(
            $this->connectTimeout ?? Defaults::DEFAULT_CONNECT_TIMEOUT,
            $this->requestTimeout ?? Defaults::DEFAULT_REQUEST_TIMEOUT,
        );

        $tokenManager = new TokenManager($this->accessToken);
        $httpClient = new ZohoHttpClient(
            transport: $transport,
            tokenManager: $tokenManager,
            edition: $this->edition,
            accountId: $this->accountId,
            requestTimeout: $this->requestTimeout,
            defaultHeaders: $this->defaultHeaders,
        );

        return new ZohoPaymentsClient($httpClient, $tokenManager, $this->edition);
    }
}
