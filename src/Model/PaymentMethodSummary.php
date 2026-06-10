<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

/** Minimal {payment_method_id, type} block used in payment list responses. */
final class PaymentMethodSummary
{
    public function __construct(
        public readonly ?string $paymentMethodId = null,
        public readonly ?string $type = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentMethodId: Coerce::optStr($data, 'payment_method_id'),
            type: Coerce::optStr($data, 'type'),
        );
    }
}
