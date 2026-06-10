<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentMethodSessionCreateParams
{
    public function __construct(
        public readonly string $customerId,
        public readonly ?string $description = null,
    ) {
        ParamHelpers::require($customerId, 'customer_id');
        ParamValidator::validateDescription($description);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'description' => $this->description,
        ];
    }
}
