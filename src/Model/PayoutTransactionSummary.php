<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PayoutTransactionSummary
{
    public function __construct(
        public readonly ?PayoutTypeSummary $charge = null,
        public readonly ?PayoutTypeSummary $refund = null,
        public readonly ?PayoutTypeSummary $adjustment = null,
        public readonly ?string $totalAmount = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            charge: Coerce::optObj($data, 'charge', [PayoutTypeSummary::class, 'fromArray']),
            refund: Coerce::optObj($data, 'refund', [PayoutTypeSummary::class, 'fromArray']),
            adjustment: Coerce::optObj($data, 'adjustment', [PayoutTypeSummary::class, 'fromArray']),
            totalAmount: Coerce::optStr($data, 'total_amount'),
        );
    }
}
