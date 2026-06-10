<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class VirtualAccountPayment
{
    public function __construct(
        public readonly ?string $paymentId = null,
        public readonly ?string $customerId = null,
        public readonly ?string $virtualAccountId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $amount = null,
        public readonly ?string $receiptEmail = null,
        public readonly ?string $dialingCode = null,
        public readonly ?string $phone = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?string $transactionReferenceNumber = null,
        public readonly ?string $paymentType = null,
        public readonly ?string $currency = null,
        public readonly ?string $balance = null,
        public readonly ?string $amountCaptured = null,
        public readonly ?string $amountRefunded = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $status = null,
        public readonly ?string $transactionType = null,
        public readonly ?string $fraudAlert = null,
        public readonly ?string $failureReason = null,
        public readonly ?string $failureCategory = null,
        public readonly ?string $nextAction = null,
        public readonly ?string $tip = null,
        public readonly ?int $date = null,
        public readonly ?VirtualAccountPaymentMethod $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: Coerce::optStr($data, 'payment_id'),
            customerId: Coerce::optStr($data, 'customer_id'),
            virtualAccountId: Coerce::optStr($data, 'virtual_account_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            customerEmail: Coerce::optStr($data, 'customer_email'),
            amount: Coerce::optStr($data, 'amount'),
            receiptEmail: Coerce::optStr($data, 'receipt_email'),
            dialingCode: Coerce::optStr($data, 'dialing_code'),
            phone: Coerce::optStr($data, 'phone'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            transactionReferenceNumber: Coerce::optStr($data, 'transaction_reference_number'),
            paymentType: Coerce::optStr($data, 'payment_type'),
            currency: Coerce::optStr($data, 'currency'),
            balance: Coerce::optStr($data, 'balance'),
            amountCaptured: Coerce::optStr($data, 'amount_captured'),
            amountRefunded: Coerce::optStr($data, 'amount_refunded'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            status: Coerce::optStr($data, 'status'),
            transactionType: Coerce::optStr($data, 'transaction_type'),
            fraudAlert: Coerce::optStr($data, 'fraud_alert'),
            failureReason: Coerce::optStr($data, 'failure_reason'),
            failureCategory: Coerce::optStr($data, 'failure_category'),
            nextAction: Coerce::optStr($data, 'next_action'),
            tip: Coerce::optStr($data, 'tip'),
            date: Coerce::optInt($data, 'date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [VirtualAccountPaymentMethod::class, 'fromArray']),
        );
    }
}
