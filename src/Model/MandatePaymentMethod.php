<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

/** Payment method on a mandate (UPI only). */
final class MandatePaymentMethod
{
    public function __construct(
        public readonly ?string $type = null,
        public readonly ?MandateUpi $upi = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            type: Coerce::optStr($data, 'type'),
            upi: Coerce::optObj($data, 'upi', [MandateUpi::class, 'fromArray']),
        );
    }
}
