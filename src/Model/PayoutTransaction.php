<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PayoutTransaction
{
    public function __construct(
        public readonly ?string $payoutId = null,
        public readonly ?string $transactionId = null,
        public readonly ?string $parentTransactionId = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $amount = null,
        public readonly ?string $fee = null,
        public readonly ?string $tax = null,
        public readonly ?string $transactionType = null,
        public readonly ?string $transactionTime = null,
        public readonly ?string $currency = null,
        public readonly ?string $customerId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $description = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            payoutId: Coerce::optStr($data, 'payout_id'),
            transactionId: Coerce::optStr($data, 'transaction_id'),
            parentTransactionId: Coerce::optStr($data, 'parent_transaction_id'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            amount: Coerce::optStr($data, 'amount'),
            fee: Coerce::optStr($data, 'fee'),
            tax: Coerce::optStr($data, 'tax'),
            transactionType: Coerce::optStr($data, 'transaction_type'),
            transactionTime: Coerce::optStr($data, 'transaction_time'),
            currency: Coerce::optStr($data, 'currency'),
            customerId: Coerce::optStr($data, 'customer_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            description: Coerce::optStr($data, 'description'),
        );
    }
}
