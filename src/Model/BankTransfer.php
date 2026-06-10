<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class BankTransfer
{
    public function __construct(
        public readonly ?string $virtualAccountNumber = null,
        public readonly ?string $mode = null,
        public readonly ?string $payerName = null,
        public readonly ?string $payerAccountNo = null,
        public readonly ?string $payerIfscCode = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            virtualAccountNumber: Coerce::optStr($data, 'virtual_account_number'),
            mode: Coerce::optStr($data, 'mode'),
            payerName: Coerce::optStr($data, 'payer_name'),
            payerAccountNo: Coerce::optStr($data, 'payer_account_no'),
            payerIfscCode: Coerce::optStr($data, 'payer_ifsc_code'),
        );
    }
}
