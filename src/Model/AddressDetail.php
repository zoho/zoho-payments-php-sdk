<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class AddressDetail
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $addressId = null,
        public readonly ?string $addressLine1 = null,
        public readonly ?string $addressLine2 = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $country = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: Coerce::optStr($data, 'name'),
            addressId: Coerce::optStr($data, 'address_id'),
            addressLine1: Coerce::optStr($data, 'address_line1'),
            addressLine2: Coerce::optStr($data, 'address_line2'),
            city: Coerce::optStr($data, 'city'),
            state: Coerce::optStr($data, 'state'),
            postalCode: Coerce::optStr($data, 'postal_code'),
            country: Coerce::optStr($data, 'country'),
        );
    }
}
