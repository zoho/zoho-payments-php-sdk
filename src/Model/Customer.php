<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Customer
{
    /**
     * @param list<MetaData> $metaData
     * @param list<CustomerPaymentMethod> $paymentMethods
     */
    public function __construct(
        public readonly ?string $customerId = null,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $dialingCode = null,
        public readonly ?int $createdTime = null,
        public readonly ?int $lastModifiedTime = null,
        public readonly array $metaData = [],
        public readonly array $paymentMethods = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: Coerce::optStr($data, 'customer_id'),
            name: Coerce::optStr($data, 'name'),
            email: Coerce::optStr($data, 'email'),
            phone: Coerce::optStr($data, 'phone'),
            dialingCode: Coerce::optStr($data, 'dialing_code'),
            createdTime: Coerce::optInt($data, 'created_time'),
            lastModifiedTime: Coerce::optInt($data, 'last_modified_time'),
            metaData: Coerce::optList($data, 'meta_data', [MetaData::class, 'fromArray']),
            paymentMethods: Coerce::optList($data, 'payment_methods', [CustomerPaymentMethod::class, 'fromArray']),
        );
    }
}
