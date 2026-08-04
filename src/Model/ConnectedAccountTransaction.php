<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountTransaction
{
    public function __construct(
        public readonly ?string $transactionId = null,
        public readonly ?string $parentTransactionId = null,
        public readonly ?string $transactionType = null,
        public readonly ?string $transactionTime = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $availableOn = null,
        public readonly ?string $settledTime = null,
        public readonly ?string $paymentMethod = null,
        public readonly ?string $cardBrand = null,
        public readonly ?string $cardType = null,
        public readonly ?string $customerId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $description = null,
        public readonly ?string $refundReason = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transactionId: Coerce::optStr($data, 'transaction_id'),
            parentTransactionId: Coerce::optStr($data, 'parent_transaction_id'),
            transactionType: Coerce::optStr($data, 'transaction_type'),
            transactionTime: Coerce::optStr($data, 'transaction_time'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
            availableOn: Coerce::optStr($data, 'available_on'),
            settledTime: Coerce::optStr($data, 'settled_time'),
            paymentMethod: Coerce::optStr($data, 'payment_method'),
            cardBrand: Coerce::optStr($data, 'card_brand'),
            cardType: Coerce::optStr($data, 'card_type'),
            customerId: Coerce::optStr($data, 'customer_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            description: Coerce::optStr($data, 'description'),
            refundReason: Coerce::optStr($data, 'refund_reason'),
        );
    }
}
