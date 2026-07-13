<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class TransferReversalCreateParams
{
    public function __construct(
        public readonly string $transferId,
        public readonly string $reversalAmount,
        public readonly ?string $description = null,
    ) {
        ParamHelpers::require($transferId, 'transfer_id');
        ParamHelpers::require($reversalAmount, 'reversal_amount');
        ParamValidator::validateDescription($description);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'transfer_id' => $this->transferId,
            'reversal_amount' => $this->reversalAmount,
            'description' => $this->description,
        ];
    }
}
