<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\PaymentLink;
use Zoho\Payments\Param\PaymentLinkCreateParams;
use Zoho\Payments\Param\PaymentLinkUpdateParams;

final class PaymentLinkService
{
    private const ENVELOPE = 'payment_links';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function create(PaymentLinkCreateParams $params): PaymentLink
    {
        return $this->http->postObject(
            '/paymentlinks',
            $params->toArray(),
            [PaymentLink::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function get(string $paymentLinkId): PaymentLink
    {
        $path = '/paymentlinks/' . ZohoHttpClient::encodePath($paymentLinkId);
        return $this->http->getObject($path, [PaymentLink::class, 'fromArray'], self::ENVELOPE);
    }

    public function update(string $paymentLinkId, PaymentLinkUpdateParams $params): PaymentLink
    {
        $path = '/paymentlinks/' . ZohoHttpClient::encodePath($paymentLinkId);
        return $this->http->putObject(
            $path,
            $params->toArray(),
            [PaymentLink::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function cancel(string $paymentLinkId): PaymentLink
    {
        $path = '/paymentlinks/' . ZohoHttpClient::encodePath($paymentLinkId) . '/cancel';
        return $this->http->putObject($path, null, [PaymentLink::class, 'fromArray'], self::ENVELOPE);
    }
}
