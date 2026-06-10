<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\PaymentMethodSession;
use Zoho\Payments\Param\PaymentMethodSessionCreateParams;

/** Requires {@see \Zoho\Payments\Edition::US}. */
final class PaymentMethodSessionService
{
    private const ENVELOPE = 'payment_method_session';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function create(PaymentMethodSessionCreateParams $params): PaymentMethodSession
    {
        return $this->http->postObject(
            '/paymentmethodsessions',
            $params->toArray(),
            [PaymentMethodSession::class, 'fromArray'],
            self::ENVELOPE,
        );
    }

    public function get(string $paymentMethodSessionId): PaymentMethodSession
    {
        $path = '/paymentmethodsessions/' . ZohoHttpClient::encodePath($paymentMethodSessionId);
        return $this->http->getObject($path, [PaymentMethodSession::class, 'fromArray'], self::ENVELOPE);
    }
}
