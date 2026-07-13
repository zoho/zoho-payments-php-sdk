<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountBankAccount
{
    public function __construct(
        public readonly ?string $connectedAccountBankAccountId = null,
        public readonly ?string $currency = null,
        public readonly ?string $routingNumber = null,
        public readonly ?string $lastFourDigits = null,
        public readonly ?string $createdBy = null,
        public readonly ?string $lastModifiedBy = null,
        public readonly ?string $createdTime = null,
        public readonly ?string $lastModifiedTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            connectedAccountBankAccountId: Coerce::optStr($data, 'connected_account_bank_account_id'),
            currency: Coerce::optStr($data, 'currency'),
            routingNumber: Coerce::optStr($data, 'routing_number'),
            lastFourDigits: Coerce::optStr($data, 'last_four_digits'),
            createdBy: Coerce::optStr($data, 'created_by'),
            lastModifiedBy: Coerce::optStr($data, 'last_modified_by'),
            createdTime: Coerce::optStr($data, 'created_time'),
            lastModifiedTime: Coerce::optStr($data, 'last_modified_time'),
        );
    }
}
