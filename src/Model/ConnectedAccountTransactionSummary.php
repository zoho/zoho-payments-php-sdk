<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountTransactionSummary
{
    public function __construct(
        public readonly ?ConnectedAccountTransactionBreakdown $charge = null,
        public readonly ?ConnectedAccountTransactionBreakdown $refund = null,
        public readonly ?ConnectedAccountTransactionBreakdown $adjustment = null,
        public readonly ?string $totalAmount = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            charge: Coerce::optObj($data, 'charge', [ConnectedAccountTransactionBreakdown::class, 'fromArray']),
            refund: Coerce::optObj($data, 'refund', [ConnectedAccountTransactionBreakdown::class, 'fromArray']),
            adjustment: Coerce::optObj($data, 'adjustment', [ConnectedAccountTransactionBreakdown::class, 'fromArray']),
            totalAmount: Coerce::optStr($data, 'total_amount'),
        );
    }
}
