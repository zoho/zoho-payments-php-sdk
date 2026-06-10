<?php

declare(strict_types=1);

namespace Zoho\Payments;

use Zoho\Payments\Auth\OAuthToken;
use Zoho\Payments\Internal\OAuthRefresher;

/** Top-level facade for the Zoho Payments SDK. */
final class ZohoPayments
{
    public static function builder(): ZohoPaymentsClientBuilder
    {
        return new ZohoPaymentsClientBuilder();
    }

    // SDK does not auto-refresh; push the new token into a running client via ZohoPaymentsClient::updateToken().
    public static function generateAccessToken(
        string $refreshToken,
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        Edition $edition,
    ): OAuthToken {
        return OAuthRefresher::generateAccessToken(
            $refreshToken,
            $clientId,
            $clientSecret,
            $redirectUri,
            $edition,
        );
    }

    private function __construct()
    {
    }
}
