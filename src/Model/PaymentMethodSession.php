<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentMethodSession
{
    public function __construct(
        public readonly ?string $paymentMethodSessionId = null,
        public readonly ?string $customerId = null,
        public readonly ?string $description = null,
        public readonly ?int $createdTime = null,
        public readonly ?string $status = null,
        public readonly ?PaymentMethodSessionDetail $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentMethodSessionId: Coerce::optStr($data, 'payment_method_session_id'),
            customerId: Coerce::optStr($data, 'customer_id'),
            description: Coerce::optStr($data, 'description'),
            createdTime: Coerce::optInt($data, 'created_time'),
            status: Coerce::optStr($data, 'status'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [PaymentMethodSessionDetail::class, 'fromArray']),
        );
    }
}
