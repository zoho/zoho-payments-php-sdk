<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentSummary
{
    public function __construct(
        public readonly ?string $paymentId = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $receiptEmail = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?string $amountCaptured = null,
        public readonly ?string $amountRefunded = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $status = null,
        public readonly ?int $date = null,
        public readonly ?PaymentMethodSummary $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: Coerce::optStr($data, 'payment_id'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            receiptEmail: Coerce::optStr($data, 'receipt_email'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            amountCaptured: Coerce::optStr($data, 'amount_captured'),
            amountRefunded: Coerce::optStr($data, 'amount_refunded'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            status: Coerce::optStr($data, 'status'),
            date: Coerce::optInt($data, 'date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [PaymentMethodSummary::class, 'fromArray']),
        );
    }
}
