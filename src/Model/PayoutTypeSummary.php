<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PayoutTypeSummary
{
    public function __construct(
        public readonly ?string $transactionType = null,
        public readonly ?string $transactionTypeFormatted = null,
        public readonly ?int $count = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $netAmountFormatted = null,
        public readonly ?string $fee = null,
        public readonly ?string $feeFormatted = null,
        public readonly ?string $amount = null,
        public readonly ?string $amountFormatted = null,
        public readonly ?string $tax = null,
        public readonly ?string $taxFormatted = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transactionType: Coerce::optStr($data, 'transaction_type'),
            transactionTypeFormatted: Coerce::optStr($data, 'transaction_type_formatted'),
            count: Coerce::optInt($data, 'count'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            netAmountFormatted: Coerce::optStr($data, 'net_amount_formatted'),
            fee: Coerce::optStr($data, 'fee'),
            feeFormatted: Coerce::optStr($data, 'fee_formatted'),
            amount: Coerce::optStr($data, 'amount'),
            amountFormatted: Coerce::optStr($data, 'amount_formatted'),
            tax: Coerce::optStr($data, 'tax'),
            taxFormatted: Coerce::optStr($data, 'tax_formatted'),
        );
    }
}
