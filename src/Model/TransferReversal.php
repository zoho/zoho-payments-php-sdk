<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferReversal
{
    public function __construct(
        public readonly ?string $transferReversalId = null,
        public readonly ?string $currency = null,
        public readonly ?string $totalAmount = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $connectedAccountName = null,
        public readonly ?string $status = null,
        public readonly ?string $failureCode = null,
        public readonly ?string $createdTime = null,
        public readonly ?string $transferId = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transferReversalId: Coerce::optStr($data, 'transfer_reversal_id'),
            currency: Coerce::optStr($data, 'currency'),
            totalAmount: Coerce::optStr($data, 'total_amount'),
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            connectedAccountName: Coerce::optStr($data, 'connected_account_name'),
            status: Coerce::optStr($data, 'status'),
            failureCode: Coerce::optStr($data, 'failure_code'),
            createdTime: Coerce::optStr($data, 'created_time'),
            transferId: Coerce::optStr($data, 'transfer_id'),
        );
    }
}
