<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

use Zoho\Payments\Auth\OAuthToken;
use Zoho\Payments\Edition;
use Zoho\Payments\Exception\ConnectionException;
use Zoho\Payments\Exception\ZohoPaymentsException;

/** Exchanges a Zoho OAuth refresh token for a new access token. */
final class OAuthRefresher
{
    private const CONNECT_TIMEOUT = 30.0;
    private const REQUEST_TIMEOUT = 60.0;
    private const DEFAULT_EXPIRES_IN = 3600;

    public static function generateAccessToken(
        string $refreshToken,
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        Edition $edition,
    ): OAuthToken {
        if ($refreshToken === '') {
            throw new \InvalidArgumentException('refresh_token must not be empty');
        }
        if ($clientId === '') {
            throw new \InvalidArgumentException('client_id must not be empty');
        }
        if ($clientSecret === '') {
            throw new \InvalidArgumentException('client_secret must not be empty');
        }
        if ($redirectUri === '') {
            throw new \InvalidArgumentException('redirect_uri must not be empty');
        }

        $url = $edition->accountsUrl() . '/oauth/v2/token';
        $form = http_build_query([
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'refresh_token',
        ]);

        $handle = curl_init();
        curl_setopt_array($handle, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $form,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT_MS => (int) round(self::CONNECT_TIMEOUT * 1000),
            CURLOPT_TIMEOUT_MS => (int) round(self::REQUEST_TIMEOUT * 1000),
            CURLOPT_FOLLOWLOCATION => false,
        ]);

        $raw = curl_exec($handle);
        if ($raw === false) {
            $errno = curl_errno($handle);
            $err = curl_error($handle);
            // No curl_close(): CurlHandle is auto-closed by GC since PHP 8.0;
            // curl_close() is a no-op there and is deprecated in PHP 8.5+.
            if ($errno === CURLE_OPERATION_TIMEDOUT) {
                throw new ConnectionException('Token refresh timed out: ' . $err);
            }
            if (in_array($errno, [CURLE_COULDNT_CONNECT, CURLE_COULDNT_RESOLVE_HOST, CURLE_COULDNT_RESOLVE_PROXY], true)) {
                throw new ConnectionException('Token refresh connection error: ' . $err);
            }
            throw new ConnectionException('Token refresh transport failure: ' . $err);
        }
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

        /** @var string $raw */
        $body = $raw;

        if ($status < 200 || $status >= 300) {
            throw new ZohoPaymentsException(
                sprintf('Token refresh failed with HTTP %d', $status),
            );
        }

        try {
            /** @var array<string, mixed>|null $parsed */
            $parsed = $body === '' ? [] : json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exc) {
            throw new ZohoPaymentsException('Token refresh response was not valid JSON', $exc);
        }
        if (!is_array($parsed)) {
            $parsed = [];
        }

        if (array_key_exists('error', $parsed) && !array_key_exists('access_token', $parsed)) {
            throw new ZohoPaymentsException('Token refresh failed');
        }

        $accessTokenRaw = $parsed['access_token'] ?? null;
        $accessToken = is_string($accessTokenRaw) ? $accessTokenRaw : '';
        if ($accessToken === '') {
            throw new ZohoPaymentsException("Token refresh response missing 'access_token'");
        }

        $expiresInRaw = $parsed['expires_in_sec'] ?? $parsed['expires_in'] ?? null;
        if ($expiresInRaw === null) {
            $expiresIn = self::DEFAULT_EXPIRES_IN;
        } elseif (is_int($expiresInRaw)) {
            $expiresIn = $expiresInRaw;
        } elseif (is_numeric($expiresInRaw)) {
            $expiresIn = (int) $expiresInRaw;
        } else {
            $expiresIn = self::DEFAULT_EXPIRES_IN;
        }

        return new OAuthToken($accessToken, $expiresIn);
    }

    private function __construct()
    {
    }
}
