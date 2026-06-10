<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** Postal address (`country` is required). */
final class PostalAddressParams
{
    public function __construct(
        public readonly string $country,
        public readonly ?string $name = null,
        public readonly ?string $addressLine1 = null,
        public readonly ?string $addressLine2 = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $postalCode = null,
    ) {
        if ($country === '') {
            throw new \InvalidArgumentException('country is required');
        }
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address_line1' => $this->addressLine1,
            'address_line2' => $this->addressLine2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postalCode,
        ];
    }
}
