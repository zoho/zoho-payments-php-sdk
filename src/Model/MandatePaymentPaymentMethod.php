<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

/** Minimal {type} block on {@see MandatePayment::$paymentMethod}. */
final class MandatePaymentPaymentMethod
{
    public function __construct(public readonly ?string $type = null)
    {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(type: Coerce::optStr($data, 'type'));
    }
}
