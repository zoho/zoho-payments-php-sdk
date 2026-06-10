<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentMethodUpdateParams
{
    public function __construct(
        public readonly string $type,
        public readonly ?CardUpdate $card = null,
        public readonly ?AchDebitUpdate $achDebit = null,
        public readonly ?PostalAddressParams $billingAddress = null,
    ) {
        ParamHelpers::require($type, 'type');
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'card' => $this->card?->toArray(),
            'ach_debit' => $this->achDebit?->toArray(),
            'billing_address' => $this->billingAddress?->toArray(),
        ];
    }
}
