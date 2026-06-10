<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class CardChecks
{
    public function __construct(
        public readonly ?string $addressLineCheck = null,
        public readonly ?string $postalCodeCheck = null,
        public readonly ?string $cvcCheck = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            addressLineCheck: Coerce::optStr($data, 'address_line_check'),
            postalCodeCheck: Coerce::optStr($data, 'postal_code_check'),
            cvcCheck: Coerce::optStr($data, 'cvc_check'),
        );
    }
}
