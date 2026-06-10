<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

use Zoho\Payments\Edition;
use Zoho\Payments\Exception\AuthenticationException;
use Zoho\Payments\Exception\ConnectionException;
use Zoho\Payments\Exception\InvalidRequestException;
use Zoho\Payments\Exception\PermissionException;
use Zoho\Payments\Exception\RateLimitException;
use Zoho\Payments\Exception\ResourceNotFoundException;
use Zoho\Payments\Exception\ZohoPaymentsAPIException;
use Zoho\Payments\Exception\ZohoPaymentsException;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Net\HttpClientInterface;
use Zoho\Payments\Net\RequestMethod;
use Zoho\Payments\Net\ZohoRequest;
use Zoho\Payments\Version;

/** Authenticated client bound to a specific account + edition; handles header layering, account_id query param, and error mapping. */
final class ZohoHttpClient
{
    private HttpClientInterface $transport;
    private TokenManager $tokenManager;
    private Edition $edition;
    private string $accountId;
    private ?float $requestTimeout;
    /** @var array<string, string> */
    private array $defaultHeaders;

    /** @param array<string, string> $defaultHeaders */
    public function __construct(
        HttpClientInterface $transport,
        TokenManager $tokenManager,
        Edition $edition,
        string $accountId,
        ?float $requestTimeout,
        array $defaultHeaders,
    ) {
        $this->transport = $transport;
        $this->tokenManager = $tokenManager;
        $this->edition = $edition;
        $this->accountId = $accountId;
        $this->requestTimeout = $requestTimeout;
        $this->defaultHeaders = $defaultHeaders;
    }

    public static function encodePath(string $segment): string
    {
        return rawurlencode($segment);
    }

    public function get(string $path, ?QueryParams $query = null): ApiResponse
    {
        return $this->request(RequestMethod::GET, $path, $query, null);
    }

    /** @param array<string, mixed>|null $body */
    public function post(string $path, ?array $body): ApiResponse
    {
        return $this->request(RequestMethod::POST, $path, null, $body);
    }

    /** @param array<string, mixed>|null $body */
    public function put(string $path, ?array $body = null): ApiResponse
    {
        return $this->request(RequestMethod::PUT, $path, null, $body);
    }

    public function delete(string $path): ApiResponse
    {
        return $this->request(RequestMethod::DELETE, $path, null, null);
    }

    /** @param array<string, mixed>|null $body */
    public function request(
        RequestMethod $method,
        string $path,
        ?QueryParams $query,
        ?array $body,
    ): ApiResponse {
        $url = $this->buildUrl($path, $query);

        $builder = ZohoRequest::builder()->method($method)->url($url);

        // User-provided default headers first (lower priority).
        foreach ($this->defaultHeaders as $name => $value) {
            $builder->setHeader($name, $value);
        }
        // SDK-managed headers override user defaults.
        $builder->setHeader('Authorization', 'Zoho-oauthtoken ' . $this->tokenManager->getAccessToken());
        $builder->setHeader('User-Agent', Version::userAgent());
        $builder->setHeader('Accept', 'application/json');

        if ($body !== null) {
            $bodyJson = JsonUtil::toJson($body);
            $builder->setHeader('Content-Type', 'application/json');
            $builder->body($bodyJson);
        }

        if ($this->requestTimeout !== null) {
            $builder->timeout($this->requestTimeout);
        }

        try {
            $response = $this->transport->execute($builder->build());
        } catch (ConnectionException $exc) {
            throw $exc;
        } catch (\Throwable $exc) {
            throw new ConnectionException('Transport failure: ' . $exc->getMessage(), $exc);
        }

        $rawBody = $response->body;
        $parsed = [];
        if ($rawBody !== null && $rawBody !== '') {
            try {
                $parsed = JsonUtil::parseObject($rawBody);
            } catch (ZohoPaymentsException) {
                $parsed = [];
            }
        }

        $apiResponse = new ApiResponse($response->statusCode, $parsed);

        if (!$apiResponse->isSuccess()) {
            $this->raiseForStatus($apiResponse);
        }

        return $apiResponse;
    }

    /**
     * @template T
     * @param callable(array<string, mixed>): T $fromArray
     * @return T
     */
    public function getObject(string $path, callable $fromArray, string ...$envelopeKeys)
    {
        return JsonUtil::unwrap($this->get($path)->body, $fromArray, ...$envelopeKeys);
    }

    /**
     * @template T
     * @param array<string, mixed>|null $body
     * @param callable(array<string, mixed>): T $fromArray
     * @return T
     */
    public function postObject(string $path, ?array $body, callable $fromArray, string ...$envelopeKeys)
    {
        return JsonUtil::unwrap($this->post($path, $body)->body, $fromArray, ...$envelopeKeys);
    }

    /**
     * @template T
     * @param array<string, mixed>|null $body
     * @param callable(array<string, mixed>): T $fromArray
     * @return T
     */
    public function putObject(string $path, ?array $body, callable $fromArray, string ...$envelopeKeys)
    {
        return JsonUtil::unwrap($this->put($path, $body)->body, $fromArray, ...$envelopeKeys);
    }

    /**
     * @template T
     * @param callable(array<string, mixed>): T $itemFromArray
     * @return ListResponse<T>
     */
    public function listObjects(
        string $path,
        ?QueryParams $query,
        callable $itemFromArray,
        string ...$envelopeKeys,
    ): ListResponse {
        $response = $this->get($path, $query);
        $entries = JsonUtil::listFromBody($response->body, ...$envelopeKeys);
        $items = [];
        foreach ($entries as $entry) {
            if (is_array($entry)) {
                /** @var array<string, mixed> $entry */
                $items[] = $itemFromArray($entry);
            }
        }
        $pageContext = JsonUtil::readPageContext($response->body);
        return new ListResponse($items, $pageContext);
    }

    private function buildUrl(string $path, ?QueryParams $query): string
    {
        $base = $this->edition->baseUrl();
        if (!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        $qs = new QueryParams();
        $qs->addAll($query);
        $qs->add('account_id', $this->accountId);

        $url = $base . $path;
        if (!$qs->isEmpty()) {
            $url .= '?' . $qs->toQueryString();
        }
        return $url;
    }

    private function raiseForStatus(ApiResponse $apiResponse): void
    {
        $status = $apiResponse->statusCode;
        $codeString = $apiResponse->getCodeString();
        $message = $apiResponse->getMessage();

        if ($status === 400 || $status === 422) {
            throw new InvalidRequestException($status, $codeString, $message);
        }
        if ($status === 401) {
            throw new AuthenticationException($codeString, $message);
        }
        if ($status === 403) {
            throw new PermissionException($codeString, $message);
        }
        if ($status === 404) {
            throw new ResourceNotFoundException($codeString, $message);
        }
        if ($status === 429) {
            throw new RateLimitException($codeString, $message);
        }
        throw new ZohoPaymentsAPIException($status, $codeString, $message);
    }
}
