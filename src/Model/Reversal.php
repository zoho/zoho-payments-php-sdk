<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Reversal
{
    public function __construct(
        public readonly ?string $reversalId = null,
        public readonly ?string $totalAmount = null,
        public readonly ?string $netAmount = null,
        public readonly ?string $feeAmount = null,
        public readonly ?string $description = null,
        public readonly ?string $status = null,
        public readonly ?string $createdTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            reversalId: Coerce::optStr($data, 'reversal_id'),
            totalAmount: Coerce::optStr($data, 'total_amount'),
            netAmount: Coerce::optStr($data, 'net_amount'),
            feeAmount: Coerce::optStr($data, 'fee_amount'),
            description: Coerce::optStr($data, 'description'),
            status: Coerce::optStr($data, 'status'),
            createdTime: Coerce::optStr($data, 'created_time'),
        );
    }
}
