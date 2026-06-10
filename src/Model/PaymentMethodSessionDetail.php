<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentMethodSessionDetail
{
    public function __construct(
        public readonly ?string $paymentMethodId = null,
        public readonly ?string $status = null,
        public readonly ?int $createdTime = null,
        public readonly ?string $type = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentMethodId: Coerce::optStr($data, 'payment_method_id'),
            status: Coerce::optStr($data, 'status'),
            createdTime: Coerce::optInt($data, 'created_time'),
            type: Coerce::optStr($data, 'type'),
        );
    }
}
