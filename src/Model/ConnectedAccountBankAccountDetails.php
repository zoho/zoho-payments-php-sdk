<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountBankAccountDetails
{
    public function __construct(
        public readonly ?string $bankName = null,
        public readonly ?string $accountNumberLastFourDigits = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            bankName: Coerce::optStr($data, 'bank_name'),
            accountNumberLastFourDigits: Coerce::optStr($data, 'account_number_last_four_digits'),
        );
    }
}
