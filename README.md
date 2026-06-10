# Zoho Payments PHP SDK

Official PHP SDK for the Zoho Payments API — supports IN, IN Sandbox, and US editions.

[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](LICENSE)

## Documentation

- **India** (`Edition::IN` / `Edition::IN_SANDBOX`): https://www.zoho.com/in/payments/api/v1/introduction/
- **United States** (`Edition::US`): https://www.zoho.com/us/payments/api/v1/introduction/

## Requirements

- **PHP 8.1+**
- **ext-curl**, **ext-json**
- A PSR-18 / PSR-17 implementation is **optional** — the SDK ships a cURL-backed transport by default.

## Installation

Install via [Composer](https://getcomposer.org/):

```sh
composer require zohopayments/php-sdk
```

To use the SDK, include Composer's [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Quick Start

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Zoho\Payments\Edition;
use Zoho\Payments\ZohoPayments;
use Zoho\Payments\Param\PaymentLinkCreateParams;

// 1. Build the client
$client = ZohoPayments::builder()
    ->accountId('23137556')
    ->edition(Edition::IN)
    ->oauthToken('1000.xxxx.yyyy')
    ->build();

// 2. Use a service
$link = $client->paymentLinks()->create(new PaymentLinkCreateParams(
    amount: 500.00,
    currency: 'INR',
    description: 'Order #1234',
    email: 'customer@example.com',
));

echo "Created: " . $link->paymentLinkId . PHP_EOL;
```

## Editions

| Edition | Payments API Base URL | OAuth Accounts URL |
|---------|-----------------------|--------------------|
| `Edition::IN` | `https://payments.zoho.in/api/v1` | `https://accounts.zoho.in` |
| `Edition::IN_SANDBOX` | `https://paymentssandbox.zoho.in/api/v1` | `https://accounts.zoho.in` |
| `Edition::US` | `https://payments.zoho.com/api/v1` | `https://accounts.zoho.com` |

Helper methods: `$edition->isIn()` returns `true` for both `IN` and `IN_SANDBOX`; `$edition->isUs()` returns `true` for `US`.

## Authentication

### Access token only

```php
$client = ZohoPayments::builder()
    ->accountId('23137556')
    ->edition(Edition::IN)
    ->oauthToken('1000.access_token_here')
    ->build();
```

### Token refresh

The SDK does **not** auto-refresh tokens. Use `ZohoPayments::generateAccessToken()` when the access token expires, then push the new token into the client:

```php
use Zoho\Payments\Auth\OAuthToken;

$fresh = ZohoPayments::generateAccessToken(
    refreshToken: '...',
    clientId: '...',
    clientSecret: '...',
    redirectUri: '...',
    edition: Edition::IN,
);

// Persist the new token in your storage layer
$myStore->save($fresh->accessToken, $fresh->expiresIn);

// Update the running client
$client->updateToken($fresh->accessToken);
```

You can also pass an `OAuthToken` directly to the builder:

```php
$token = ZohoPayments::generateAccessToken(/* ... */);
$client = ZohoPayments::builder()
    ->accountId('23137556')
    ->edition(Edition::IN)
    ->oauthToken($token)
    ->build();
```

`OAuthToken` exposes `accessToken` and `expiresIn` (token lifetime in seconds, as returned by IAM).

## Client configuration

```php
$client = ZohoPayments::builder()
    ->accountId('23137556')                       // Required
    ->edition(Edition::IN)                        // Required
    ->oauthToken('1000.xxxx.yyyy')                // Required
    ->connectTimeout(15.0)                        // Default: 30 seconds
    ->requestTimeout(45.0)                        // Default: 60 seconds
    ->addDefaultHeader('X-Custom-Header', 'value')
    ->build();
```

Reserved headers (`Authorization`, `User-Agent`, `Accept`, `Content-Type`, `Content-Length`, `Host`) are managed by the SDK and cannot be overridden via `addDefaultHeader()`.

## Services

| Accessor | Description | Editions |
|----------|-------------|----------|
| `$client->paymentLinks()` | Payment link CRUD | All |
| `$client->paymentSessions()` | Payment sessions | All |
| `$client->customers()` | Customers | All (list/delete: US only) |
| `$client->payments()` | Payments | All (create: US only) |
| `$client->refunds()` | Refunds | All |
| `$client->paymentMethods()` | Saved payment methods | US only |
| `$client->paymentMethodSessions()` | Payment-method collection sessions | US only |
| `$client->mandates()` | Recurring mandates | IN only |
| `$client->collect()` | Virtual accounts (Collect) | IN only |

## Examples

### Payment link

```php
use Zoho\Payments\Param\PaymentLinkCreateParams;
use Zoho\Payments\Param\NotifyCustomerParams;

$link = $client->paymentLinks()->create(new PaymentLinkCreateParams(
    amount: 500.00,
    currency: 'INR',
    description: 'Order #1234',
    email: 'customer@example.com',
    notifyCustomer: new NotifyCustomerParams(email: true, sms: false),
));

// Retrieve
$fetched = $client->paymentLinks()->get($link->paymentLinkId);

// Cancel
$cancelled = $client->paymentLinks()->cancel($link->paymentLinkId);
```

### Customer

```php
use Zoho\Payments\Param\CustomerCreateParams;
use Zoho\Payments\Param\MetaDataParams;

$customer = $client->customers()->create(new CustomerCreateParams(
    name: 'Jane Doe',
    email: 'jane@example.com',
    metaData: [new MetaDataParams('source', 'web')],
));

$fetched = $client->customers()->get($customer->customerId);
echo $fetched->customerId . ' ' . $fetched->customerName . PHP_EOL;
```

### Refund

```php
use Zoho\Payments\Param\RefundCreateParams;

$refund = $client->refunds()->create(
    paymentId: '1234567',
    params: new RefundCreateParams(
        amount: 100.00,
        reason: 'requested_by_customer',
        type: 'full',
    ),
);
```

### Mandate (IN)

```php
use Zoho\Payments\Param\MandateDetailsParams;
use Zoho\Payments\Param\MandateEnrollmentSessionCreateParams;

$enrollment = $client->mandates()->createEnrollmentSession(new MandateEnrollmentSessionCreateParams(
    amount: 0.00,
    currency: 'INR',
    customerId: '173000002315107',
    description: 'SIP enrollment',
    mandateDetails: new MandateDetailsParams(
        paymentMethodType: 'upi',
        frequency: 'monthly',
        description: 'Monthly SIP',
        amountRule: 'variable',
        maxAmount: 5000.00,
    ),
));
```

## Error handling

All API errors raise a subclass of `ZohoPaymentsException`.

| Exception | HTTP |
|-----------|------|
| `AuthenticationException` | 401 |
| `PermissionException` | 403 |
| `ResourceNotFoundException` | 404 |
| `InvalidRequestException` | 400, 422 |
| `RateLimitException` | 429 |
| `ZohoPaymentsAPIException` | Any other non-2xx |
| `ConnectionException` | Network / I/O failure |

```php
use Zoho\Payments\Exception\AuthenticationException;
use Zoho\Payments\Exception\InvalidRequestException;
use Zoho\Payments\Exception\ZohoPaymentsAPIException;

try {
    $client->payments()->get('123456789');
} catch (AuthenticationException $e) {
    // refresh the token and retry
} catch (InvalidRequestException $e) {
    echo $e->codeString . ' ' . $e->apiErrorMessage;
} catch (ZohoPaymentsAPIException $e) {
    echo 'other API error: ' . $e->httpStatusCode;
}
```

## Custom HTTP transport

`DefaultHttpClient` is cURL-backed. To plug in your own retries, proxy, instrumentation, or a PSR-18 client, implement `HttpClientInterface`:

```php
use Zoho\Payments\Net\HttpClientInterface;
use Zoho\Payments\Net\ZohoRequest;
use Zoho\Payments\Net\ZohoResponse;

final class MyTransport implements HttpClientInterface
{
    public function execute(ZohoRequest $request): ZohoResponse
    {
        // ... send $request->method / $request->url / $request->headers / $request->body
        return new ZohoResponse(statusCode: 200, headers: [], body: '{...}');
    }
}

$client = ZohoPayments::builder()
    ->accountId('...')
    ->edition(Edition::IN)
    ->oauthToken('...')
    ->httpClient(new MyTransport())
    ->build();
```

When you inject a custom transport you cannot also set `connectTimeout` — the transport manages its own connection lifecycle.

## License

[Apache License 2.0](LICENSE)
