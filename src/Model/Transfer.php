<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Transfer
{
    /** @param list<Reversal> $reversals */
    public function __construct(
        public readonly ?string $transferId = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $totalAmount = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $feeRate = null,
        public readonly ?string $feeTaxAmount = null,
        public readonly ?string $feeTaxRate = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $connectedAccountName = null,
        public readonly ?string $description = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $failureCode = null,
        public readonly ?string $reversedAmount = null,
        public readonly ?string $availableAmountForReversal = null,
        public readonly ?string $createdTime = null,
        public readonly array $reversals = [],
        public readonly ?TransferPaymentDetails $paymentDetails = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transferId: Coerce::optStr($data, 'transfer_id'),
            paymentId: Coerce::optStr($data, 'payment_id'),
            totalAmount: Coerce::optStr($data, 'total_amount'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            feeRate: Coerce::optStr($data, 'fee_rate'),
            feeTaxAmount: Coerce::optStr($data, 'fee_tax_amount'),
            feeTaxRate: Coerce::optStr($data, 'fee_tax_rate'),
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            connectedAccountName: Coerce::optStr($data, 'connected_account_name'),
            description: Coerce::optStr($data, 'description'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
            failureCode: Coerce::optStr($data, 'failure_code'),
            reversedAmount: Coerce::optStr($data, 'reversed_amount'),
            availableAmountForReversal: Coerce::optStr($data, 'available_amount_for_reversal'),
            createdTime: Coerce::optStr($data, 'created_time'),
            reversals: Coerce::optList($data, 'reversals', [Reversal::class, 'fromArray']),
            paymentDetails: Coerce::optObj($data, 'payment_details', [TransferPaymentDetails::class, 'fromArray']),
        );
    }
}
