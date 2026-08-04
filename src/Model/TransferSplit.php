<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferSplit
{
    public function __construct(
        public readonly ?string $transferId = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $currency = null,
        public readonly ?string $transferAmount = null,
        public readonly ?string $netTransferAmount = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $feeTaxAmount = null,
        public readonly ?string $status = null,
        public readonly ?string $errorCode = null,
        public readonly ?string $message = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transferId: Coerce::optStr($data, 'transfer_id'),
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            currency: Coerce::optStr($data, 'currency'),
            transferAmount: Coerce::optStr($data, 'transfer_amount'),
            netTransferAmount: Coerce::optStr($data, 'net_transfer_amount'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            feeTaxAmount: Coerce::optStr($data, 'fee_tax_amount'),
            status: Coerce::optStr($data, 'status'),
            errorCode: Coerce::optStr($data, 'error_code'),
            message: Coerce::optStr($data, 'message'),
        );
    }
}
