<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferReversalCreateResponse
{
    public function __construct(
        public readonly ?string $transferReversalId = null,
        public readonly ?string $transferId = null,
        public readonly ?string $transferReversalAmount = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transferReversalId: Coerce::optStr($data, 'transfer_reversal_id'),
            transferId: Coerce::optStr($data, 'transfer_id'),
            transferReversalAmount: Coerce::optStr($data, 'transfer_reversal_amount'),
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
        );
    }
}
