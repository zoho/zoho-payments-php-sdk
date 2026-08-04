<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountTransactionBreakdown
{
    public function __construct(
        public readonly ?string $transactionType = null,
        public readonly ?int $count = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $fee = null,
        public readonly ?string $amount = null,
        public readonly ?string $tax = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            transactionType: Coerce::optStr($data, 'transaction_type'),
            count: Coerce::optInt($data, 'count'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            fee: Coerce::optStr($data, 'fee'),
            amount: Coerce::optStr($data, 'amount'),
            tax: Coerce::optStr($data, 'tax'),
        );
    }
}
