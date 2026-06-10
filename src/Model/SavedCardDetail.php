<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class SavedCardDetail
{
    public function __construct(
        public readonly ?string $cardHolderName = null,
        public readonly ?string $lastFourDigits = null,
        public readonly ?string $expiryMonth = null,
        public readonly ?string $expiryYear = null,
        public readonly ?string $brand = null,
        public readonly ?string $funding = null,
        public readonly ?string $country = null,
        public readonly ?CardChecks $cardChecks = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            cardHolderName: Coerce::optStr($data, 'card_holder_name'),
            lastFourDigits: Coerce::optStr($data, 'last_four_digits'),
            expiryMonth: Coerce::optStr($data, 'expiry_month'),
            expiryYear: Coerce::optStr($data, 'expiry_year'),
            brand: Coerce::optStr($data, 'brand'),
            funding: Coerce::optStr($data, 'funding'),
            country: Coerce::optStr($data, 'country'),
            cardChecks: Coerce::optObj($data, 'card_checks', [CardChecks::class, 'fromArray']),
        );
    }
}
