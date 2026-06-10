<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Edition;
use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\Customer;
use Zoho\Payments\Model\CustomerSummary;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Param\CustomerCreateParams;
use Zoho\Payments\Param\CustomerListParams;

final class CustomerService
{
    private const SINGLE_ENVELOPE = 'customer';
    private const LIST_ENVELOPE = 'customers';

    public function __construct(
        private readonly ZohoHttpClient $http,
        private readonly Edition $edition,
    ) {
    }

    public function create(CustomerCreateParams $params): Customer
    {
        return $this->http->postObject(
            '/customers',
            $params->toArray(),
            [Customer::class, 'fromArray'],
            self::SINGLE_ENVELOPE,
        );
    }

    public function get(string $customerId): Customer
    {
        $path = '/customers/' . ZohoHttpClient::encodePath($customerId);
        return $this->http->getObject($path, [Customer::class, 'fromArray'], self::SINGLE_ENVELOPE);
    }

    // Requires Edition::US.
    /** @return ListResponse<CustomerSummary> */
    public function list(?CustomerListParams $params = null): ListResponse
    {
        if (!$this->edition->isUs()) {
            throw new \BadMethodCallException('customers.list() is available only on Edition::US');
        }
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/customers',
            $query,
            [CustomerSummary::class, 'fromArray'],
            self::LIST_ENVELOPE,
        );
    }

    // Requires Edition::US.
    public function delete(string $customerId): void
    {
        if (!$this->edition->isUs()) {
            throw new \BadMethodCallException('customers.delete() is available only on Edition::US');
        }
        $path = '/customers/' . ZohoHttpClient::encodePath($customerId);
        $this->http->delete($path);
    }
}
