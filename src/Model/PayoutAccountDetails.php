<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PayoutAccountDetails
{
    public function __construct(
        public readonly ?string $bankName = null,
        public readonly ?string $accountHolder = null,
        public readonly ?string $accountNumberLastFourDigits = null,
        public readonly ?string $routingNumber = null,
        public readonly ?string $type = null,
        public readonly ?string $country = null,
        public readonly ?string $currency = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            bankName: Coerce::optStr($data, 'bank_name'),
            accountHolder: Coerce::optStr($data, 'account_holder'),
            accountNumberLastFourDigits: Coerce::optStr($data, 'account_number_last_four_digits'),
            routingNumber: Coerce::optStr($data, 'routing_number'),
            type: Coerce::optStr($data, 'type'),
            country: Coerce::optStr($data, 'country'),
            currency: Coerce::optStr($data, 'currency'),
        );
    }
}
