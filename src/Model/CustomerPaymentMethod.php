<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class CustomerPaymentMethod
{
    public function __construct(
        public readonly ?string $paymentMethodId = null,
        public readonly ?string $type = null,
        public readonly ?string $brand = null,
        public readonly ?string $lastFourDigits = null,
        public readonly ?string $expiryMonth = null,
        public readonly ?string $expiryYear = null,
        public readonly ?CustomerCard $card = null,
        public readonly ?CustomerAchDebit $achDebit = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentMethodId: Coerce::optStr($data, 'payment_method_id'),
            type: Coerce::optStr($data, 'type'),
            brand: Coerce::optStr($data, 'brand'),
            lastFourDigits: Coerce::optStr($data, 'last_four_digits'),
            expiryMonth: Coerce::optStr($data, 'expiry_month'),
            expiryYear: Coerce::optStr($data, 'expiry_year'),
            card: Coerce::optObj($data, 'card', [CustomerCard::class, 'fromArray']),
            achDebit: Coerce::optObj($data, 'ach_debit', [CustomerAchDebit::class, 'fromArray']),
        );
    }
}
