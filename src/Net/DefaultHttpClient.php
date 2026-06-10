<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

use Zoho\Payments\Exception\ConnectionException;
use Zoho\Payments\Internal\Defaults;

final class DefaultHttpClient implements HttpClientInterface
{
    private float $connectTimeout;
    private float $defaultTimeout;
    /** @var resource|\CurlHandle */
    private $handle;

    public function __construct(
        ?float $connectTimeout = null,
        ?float $defaultTimeout = null,
    ) {
        $this->connectTimeout = $connectTimeout ?? Defaults::DEFAULT_CONNECT_TIMEOUT;
        $this->defaultTimeout = $defaultTimeout ?? Defaults::DEFAULT_REQUEST_TIMEOUT;
        $this->handle = curl_init();
    }

    public function execute(ZohoRequest $request): ZohoResponse
    {
        $timeout = $request->timeout ?? $this->defaultTimeout;

        $flatHeaders = [];
        foreach ($request->headers as $name => $values) {
            // RFC 7230 §3.2.2 — comma-join multi-valued headers
            $flatHeaders[] = $name . ': ' . implode(', ', $values);
        }

        curl_reset($this->handle);
        curl_setopt_array($this->handle, [
            CURLOPT_URL => $request->url,
            CURLOPT_CUSTOMREQUEST => $request->method->value,
            CURLOPT_HTTPHEADER => $flatHeaders,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CONNECTTIMEOUT_MS => (int) round($this->connectTimeout * 1000),
            CURLOPT_TIMEOUT_MS => (int) round($timeout * 1000),
            CURLOPT_FOLLOWLOCATION => false,
        ]);

        if ($request->body !== null) {
            curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->body);
        }

        $raw = curl_exec($this->handle);
        if ($raw === false) {
            $errno = curl_errno($this->handle);
            $err = curl_error($this->handle);
            if ($errno === CURLE_OPERATION_TIMEDOUT) {
                throw new ConnectionException(sprintf('Request timed out: %s', $err));
            }
            if (in_array($errno, [CURLE_COULDNT_CONNECT, CURLE_COULDNT_RESOLVE_HOST, CURLE_COULDNT_RESOLVE_PROXY], true)) {
                throw new ConnectionException(sprintf('Connection error: %s', $err));
            }
            throw new ConnectionException(sprintf('Transport failure: %s', $err));
        }

        /** @var string $raw */
        $headerSize = (int) curl_getinfo($this->handle, CURLINFO_HEADER_SIZE);
        $statusCode = (int) curl_getinfo($this->handle, CURLINFO_RESPONSE_CODE);
        $headerBlock = substr($raw, 0, $headerSize);
        $bodyText = substr($raw, $headerSize);
        if ($bodyText === '') {
            $bodyText = null;
        }

        $headers = self::parseHeaderBlock($headerBlock);

        return new ZohoResponse(
            statusCode: $statusCode,
            headers: $headers,
            body: $bodyText,
        );
    }

    // Last status line wins — handles Expect: 100-continue where curl prefixes "HTTP/1.1 100 Continue" before the final headers.
    /** @return array<string, list<string>> */
    private static function parseHeaderBlock(string $block): array
    {
        $headers = [];
        $lines = preg_split("/\r\n|\n|\r/", $block) ?: [];
        foreach ($lines as $line) {
            if ($line === '' || stripos($line, 'HTTP/') === 0) {
                if (stripos($line, 'HTTP/') === 0) {
                    // New status line — reset accumulated headers (keeps the final block)
                    $headers = [];
                }
                continue;
            }
            $pos = strpos($line, ':');
            if ($pos === false) {
                continue;
            }
            $name = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));
            if ($name === '') {
                continue;
            }
            $headers[$name][] = $value;
        }
        return $headers;
    }
}
