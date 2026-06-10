<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class AchDebitDetail
{
    public function __construct(
        public readonly ?string $accountHolderName = null,
        public readonly ?string $lastFourDigits = null,
        public readonly ?string $accountHolderType = null,
        public readonly ?string $accountType = null,
        public readonly ?string $bankName = null,
        public readonly ?string $routingNumber = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            accountHolderName: Coerce::optStr($data, 'account_holder_name'),
            lastFourDigits: Coerce::optStr($data, 'last_four_digits'),
            accountHolderType: Coerce::optStr($data, 'account_holder_type'),
            accountType: Coerce::optStr($data, 'account_type'),
            bankName: Coerce::optStr($data, 'bank_name'),
            routingNumber: Coerce::optStr($data, 'routing_number'),
        );
    }
}
