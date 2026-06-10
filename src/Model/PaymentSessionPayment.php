<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentSessionPayment
{
    public function __construct(
        public readonly ?string $paymentId = null,
        public readonly ?string $status = null,
        public readonly ?int $createdTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: Coerce::optStr($data, 'payment_id'),
            status: Coerce::optStr($data, 'status'),
            createdTime: Coerce::optInt($data, 'created_time'),
        );
    }
}
