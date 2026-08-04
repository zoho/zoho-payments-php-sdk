<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferReversalDetail
{
    public function __construct(
        public readonly ?string $transferReversalId = null,
        public readonly ?string $transferId = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $refundId = null,
        public readonly ?string $totalAmount = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $connectedAccountName = null,
        public readonly ?string $status = null,
        public readonly ?string $failureCode = null,
        public readonly ?string $description = null,
        public readonly ?string $currency = null,
        public readonly ?string $createdTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transferReversalId: Coerce::optStr($data, 'transfer_reversal_id'),
            transferId: Coerce::optStr($data, 'transfer_id'),
            paymentId: Coerce::optStr($data, 'payment_id'),
            refundId: Coerce::optStr($data, 'refund_id'),
            totalAmount: Coerce::optStr($data, 'total_amount'),
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            connectedAccountName: Coerce::optStr($data, 'connected_account_name'),
            status: Coerce::optStr($data, 'status'),
            failureCode: Coerce::optStr($data, 'failure_code'),
            description: Coerce::optStr($data, 'description'),
            currency: Coerce::optStr($data, 'currency'),
            createdTime: Coerce::optStr($data, 'created_time'),
        );
    }
}