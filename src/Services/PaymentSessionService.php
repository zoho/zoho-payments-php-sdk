<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\PaymentSession;
use Zoho\Payments\Param\PaymentSessionCreateParams;

final class PaymentSessionService
{
    private const ENVELOPE = 'payments_session';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function create(PaymentSessionCreateParams $params): PaymentSession
    {
        return $this->http->postObject(
            '/paymentsessions',
            $params->toArray(),
            [PaymentSession::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function get(string $paymentSessionId): PaymentSession
    {
        $path = '/paymentsessions/' . ZohoHttpClient::encodePath($paymentSessionId);
        return $this->http->getObject($path, [PaymentSession::class, 'fromArray'], self::ENVELOPE);
    }
}
