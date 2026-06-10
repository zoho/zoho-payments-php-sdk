<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\Refund;
use Zoho\Payments\Param\RefundCreateParams;

final class RefundService
{
    private const ENVELOPE = 'refund';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function create(string $paymentId, RefundCreateParams $params): Refund
    {
        $path = '/payments/' . ZohoHttpClient::encodePath($paymentId) . '/refunds';
        return $this->http->postObject(
            $path,
            $params->toArray(),
            [Refund::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function get(string $refundId): Refund
    {
        $path = '/refunds/' . ZohoHttpClient::encodePath($refundId);
        return $this->http->getObject($path, [Refund::class, 'fromArray'], self::ENVELOPE);
    }
}
