<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferPaymentDetails
{
    public function __construct(
        public readonly ?string $amount = null,
        public readonly ?string $amountFormatted = null,
        public readonly ?string $currency = null,
        public readonly ?string $paymentDateFormatted = null,
        public readonly ?string $statusFormatted = null,
        public readonly ?string $paymentDate = null,
        public readonly ?string $status = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: Coerce::optStr($data, 'amount'),
            amountFormatted: Coerce::optStr($data, 'amount_formatted'),
            currency: Coerce::optStr($data, 'currency'),
            paymentDateFormatted: Coerce::optStr($data, 'payment_date_formatted'),
            statusFormatted: Coerce::optStr($data, 'status_formatted'),
            paymentDate: Coerce::optStr($data, 'payment_date'),
            status: Coerce::optStr($data, 'status'),
        );
    }
}
