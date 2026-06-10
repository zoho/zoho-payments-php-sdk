<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\PaymentMethod;
use Zoho\Payments\Param\PaymentMethodUpdateParams;

/** Requires {@see \Zoho\Payments\Edition::US}. */
final class PaymentMethodService
{
    private const ENVELOPE = 'payment_method';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function get(string $paymentMethodId): PaymentMethod
    {
        $path = '/paymentmethods/' . ZohoHttpClient::encodePath($paymentMethodId);
        return $this->http->getObject($path, [PaymentMethod::class, 'fromArray'], self::ENVELOPE);
    }

    public function update(string $paymentMethodId, PaymentMethodUpdateParams $params): PaymentMethod
    {
        $path = '/paymentmethods/' . ZohoHttpClient::encodePath($paymentMethodId);
        return $this->http->putObject(
            $path,
            $params->toArray(),
            [PaymentMethod::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function delete(string $paymentMethodId): void
    {
        $path = '/paymentmethods/' . ZohoHttpClient::encodePath($paymentMethodId);
        $this->http->delete($path);
    }
}
