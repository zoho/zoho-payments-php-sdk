<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Payment
{
    /** @param list<MetaData> $metaData */
    public function __construct(
        public readonly ?string $paymentId = null,
        public readonly ?string $phone = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $paymentsSessionId = null,
        public readonly ?string $receiptEmail = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?string $transactionReferenceNumber = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $amountCaptured = null,
        public readonly ?string $amountRefunded = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $netTaxAmount = null,
        public readonly ?string $totalFeeAmount = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $status = null,
        public readonly ?float $exchangeRate = null,
        public readonly ?string $statementDescriptor = null,
        public readonly ?string $description = null,
        public readonly ?int $date = null,
        public readonly ?PaymentMethodDetail $paymentMethod = null,
        public readonly array $metaData = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: Coerce::optStr($data, 'payment_id'),
            phone: Coerce::optStr($data, 'phone'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            paymentsSessionId: Coerce::optStr($data, 'payments_session_id'),
            receiptEmail: Coerce::optStr($data, 'receipt_email'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            transactionReferenceNumber: Coerce::optStr($data, 'transaction_reference_number'),
            invoiceNumber: Coerce::optStr($data, 'invoice_number'),
            amountCaptured: Coerce::optStr($data, 'amount_captured'),
            amountRefunded: Coerce::optStr($data, 'amount_refunded'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            netTaxAmount: Coerce::optStr($data, 'net_tax_amount'),
            totalFeeAmount: Coerce::optStr($data, 'total_fee_amount'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            status: Coerce::optStr($data, 'status'),
            exchangeRate: Coerce::optFloat($data, 'exchange_rate'),
            statementDescriptor: Coerce::optStr($data, 'statement_descriptor'),
            description: Coerce::optStr($data, 'description'),
            date: Coerce::optInt($data, 'date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [PaymentMethodDetail::class, 'fromArray']),
            metaData: Coerce::optList($data, 'meta_data', [MetaData::class, 'fromArray']),
        );
    }
}
