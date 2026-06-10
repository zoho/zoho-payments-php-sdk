<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class CustomerSummary
{
    public function __construct(
        public readonly ?string $customerId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $customerPhone = null,
        public readonly ?string $customerStatus = null,
        public readonly ?int $createdTime = null,
        public readonly ?int $lastModifiedTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: Coerce::optStr($data, 'customer_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            customerEmail: Coerce::optStr($data, 'customer_email'),
            customerPhone: Coerce::optStr($data, 'customer_phone'),
            customerStatus: Coerce::optStr($data, 'customer_status'),
            createdTime: Coerce::optInt($data, 'created_time'),
            lastModifiedTime: Coerce::optInt($data, 'last_modified_time'),
        );
    }
}
