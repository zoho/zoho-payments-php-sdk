<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Mandate
{
    public function __construct(
        public readonly ?string $mandateId = null,
        public readonly ?string $customerId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $customerPhone = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $amountRule = null,
        public readonly ?string $frequency = null,
        public readonly ?string $status = null,
        public readonly ?string $description = null,
        public readonly ?int $debitDay = null,
        public readonly ?string $debitRule = null,
        public readonly ?int $startDate = null,
        public readonly ?int $endDate = null,
        public readonly ?MandatePaymentMethod $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            mandateId: Coerce::optStr($data, 'mandate_id'),
            customerId: Coerce::optStr($data, 'customer_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            customerEmail: Coerce::optStr($data, 'customer_email'),
            customerPhone: Coerce::optStr($data, 'customer_phone'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            amountRule: Coerce::optStr($data, 'amount_rule'),
            frequency: Coerce::optStr($data, 'frequency'),
            status: Coerce::optStr($data, 'status'),
            description: Coerce::optStr($data, 'description'),
            debitDay: Coerce::optInt($data, 'debit_day'),
            debitRule: Coerce::optStr($data, 'debit_rule'),
            startDate: Coerce::optInt($data, 'start_date'),
            endDate: Coerce::optInt($data, 'end_date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [MandatePaymentMethod::class, 'fromArray']),
        );
    }
}
