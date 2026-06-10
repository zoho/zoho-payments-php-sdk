<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class MandatePayment
{
    public function __construct(
        public readonly ?string $paymentsSessionId = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $customerId = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $statementDescriptor = null,
        public readonly ?string $description = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?int $date = null,
        public readonly ?MandatePaymentPaymentMethod $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentsSessionId: Coerce::optStr($data, 'payments_session_id'),
            invoiceNumber: Coerce::optStr($data, 'invoice_number'),
            customerId: Coerce::optStr($data, 'customer_id'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
            statementDescriptor: Coerce::optStr($data, 'statement_descriptor'),
            description: Coerce::optStr($data, 'description'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            date: Coerce::optInt($data, 'date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [MandatePaymentPaymentMethod::class, 'fromArray']),
        );
    }
}
