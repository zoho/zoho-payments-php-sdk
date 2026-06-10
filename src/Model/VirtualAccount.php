<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class VirtualAccount
{
    /** @param list<MetaData> $metaData */
    public function __construct(
        public readonly ?string $virtualAccountId = null,
        public readonly ?string $accountNumber = null,
        public readonly ?string $ifscCode = null,
        public readonly ?string $beneficiaryName = null,
        public readonly ?string $description = null,
        public readonly ?string $customerId = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?string $status = null,
        public readonly ?string $expiresAt = null,
        public readonly ?int $createdTime = null,
        public readonly ?int $lastModifiedTime = null,
        public readonly array $metaData = [],
        public readonly ?float $minimumAmount = null,
        public readonly ?float $maximumAmount = null,
        public readonly ?float $amountPaid = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            virtualAccountId: Coerce::optStr($data, 'virtual_account_id'),
            accountNumber: Coerce::optStr($data, 'account_number'),
            ifscCode: Coerce::optStr($data, 'ifsc_code'),
            beneficiaryName: Coerce::optStr($data, 'beneficiary_name'),
            description: Coerce::optStr($data, 'description'),
            customerId: Coerce::optStr($data, 'customer_id'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            status: Coerce::optStr($data, 'status'),
            expiresAt: Coerce::optStr($data, 'expires_at'),
            createdTime: Coerce::optInt($data, 'created_time'),
            lastModifiedTime: Coerce::optInt($data, 'last_modified_time'),
            metaData: Coerce::optList($data, 'meta_data', [MetaData::class, 'fromArray']),
            minimumAmount: Coerce::optFloat($data, 'minimum_amount'),
            maximumAmount: Coerce::optFloat($data, 'maximum_amount'),
            amountPaid: Coerce::optFloat($data, 'amount_paid'),
        );
    }
}
