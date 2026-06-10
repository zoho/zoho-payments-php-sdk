<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Model\VirtualAccount;
use Zoho\Payments\Model\VirtualAccountPayment;
use Zoho\Payments\Param\VirtualAccountCreateParams;
use Zoho\Payments\Param\VirtualAccountPaymentListParams;
use Zoho\Payments\Param\VirtualAccountUpdateParams;

/** Requires {@see \Zoho\Payments\Edition::IN}. */
final class CollectService
{
    private const SINGLE_ENVELOPE = 'virtual_account';
    private const PAYMENTS_ENVELOPE = 'payments';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function create(VirtualAccountCreateParams $params): VirtualAccount
    {
        return $this->http->postObject(
            '/virtualaccounts',
            $params->toArray(),
            [VirtualAccount::class, 'fromArray'],
            self::SINGLE_ENVELOPE,
        );
    }

    public function update(string $virtualAccountId, VirtualAccountUpdateParams $params): VirtualAccount
    {
        $path = '/virtualaccounts/' . ZohoHttpClient::encodePath($virtualAccountId);
        return $this->http->putObject(
            $path,
            $params->toArray(),
            [VirtualAccount::class, 'fromArray'],
            self::SINGLE_ENVELOPE,
        );
    }

    public function get(string $virtualAccountId): VirtualAccount
    {
        $path = '/virtualaccounts/' . ZohoHttpClient::encodePath($virtualAccountId);
        return $this->http->getObject($path, [VirtualAccount::class, 'fromArray'], self::SINGLE_ENVELOPE);
    }

    /** @return ListResponse<VirtualAccountPayment> */
    public function listPayments(
        string $virtualAccountId,
        ?VirtualAccountPaymentListParams $params = null,
    ): ListResponse {
        $path = '/virtualaccounts/' . ZohoHttpClient::encodePath($virtualAccountId) . '/payments';
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            $path,
            $query,
            [VirtualAccountPayment::class, 'fromArray'],
            self::PAYMENTS_ENVELOPE,
        );
    }

    public function close(string $virtualAccountId): void
    {
        $path = '/virtualaccounts/' . ZohoHttpClient::encodePath($virtualAccountId) . '/close';
        $this->http->put($path, null);
    }
}
