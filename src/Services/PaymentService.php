<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Edition;
use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Model\Payment;
use Zoho\Payments\Model\PaymentSummary;
use Zoho\Payments\Param\PaymentCreateParams;
use Zoho\Payments\Param\PaymentListParams;

final class PaymentService
{
    private const SINGLE_ENVELOPE = 'payment';
    private const LIST_ENVELOPE = 'payments';

    public function __construct(
        private readonly ZohoHttpClient $http,
        private readonly Edition $edition,
    ) {
    }

    // Requires Edition::US.
    public function create(PaymentCreateParams $params): Payment
    {
        if (!$this->edition->isUs()) {
            throw new \BadMethodCallException('payments.create() is available only on Edition::US');
        }
        return $this->http->postObject(
            '/payments',
            $params->toArray(),
            [Payment::class, 'fromArray'],
            self::SINGLE_ENVELOPE,
        );
    }

    public function get(string $paymentId): Payment
    {
        $path = '/payments/' . ZohoHttpClient::encodePath($paymentId);
        return $this->http->getObject($path, [Payment::class, 'fromArray'], self::SINGLE_ENVELOPE);
    }

    /** @return ListResponse<PaymentSummary> */
    public function list(?PaymentListParams $params = null): ListResponse
    {
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/payments',
            $query,
            [PaymentSummary::class, 'fromArray'],
            self::LIST_ENVELOPE,
        );
    }
}
