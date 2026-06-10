<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class CardUpdate
{
    public function __construct(
        public readonly ?string $expiryMonth = null,
        public readonly ?string $expiryYear = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'expiry_month' => $this->expiryMonth,
            'expiry_year' => $this->expiryYear,
        ];
    }
}
