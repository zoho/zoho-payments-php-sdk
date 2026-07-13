<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Model\Payout;
use Zoho\Payments\Model\PayoutDetail;
use Zoho\Payments\Model\PayoutTransaction;
use Zoho\Payments\Param\ParamHelpers;
use Zoho\Payments\Param\PayoutListParams;
use Zoho\Payments\Param\PayoutTransactionListParams;

final class PayoutService
{
    private const SINGLE_ENVELOPE = 'payout';
    private const LIST_ENVELOPE = 'payouts';
    private const TRANSACTIONS_ENVELOPE = 'transactions';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function get(string $payoutId): PayoutDetail
    {
        ParamHelpers::require($payoutId, 'payoutId');
        $path = '/payouts/' . ZohoHttpClient::encodePath($payoutId);
        return $this->http->getObject($path, [PayoutDetail::class, 'fromArray'], self::SINGLE_ENVELOPE);
    }

    /** @return ListResponse<Payout> */
    public function list(?PayoutListParams $params = null): ListResponse
    {
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/payouts',
            $query,
            [Payout::class, 'fromArray'],
            self::LIST_ENVELOPE,
        );
    }

    /** @return ListResponse<PayoutTransaction> */
    public function listTransactions(
        string $payoutId,
        ?PayoutTransactionListParams $params = null,
    ): ListResponse {
        ParamHelpers::require($payoutId, 'payoutId');
        $path = '/payouts/' . ZohoHttpClient::encodePath($payoutId) . '/transactions';
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            $path,
            $query,
            [PayoutTransaction::class, 'fromArray'],
            self::TRANSACTIONS_ENVELOPE,
        );
    }
}
