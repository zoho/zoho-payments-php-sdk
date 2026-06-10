<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentLinkPayment
{
    public function __construct(
        public readonly ?string $paymentId = null,
        public readonly ?string $amount = null,
        public readonly ?string $type = null,
        public readonly ?string $status = null,
        public readonly ?int $date = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: Coerce::optStr($data, 'payment_id'),
            amount: Coerce::optStr($data, 'amount'),
            type: Coerce::optStr($data, 'type'),
            status: Coerce::optStr($data, 'status'),
            date: Coerce::optInt($data, 'date'),
        );
    }
}
