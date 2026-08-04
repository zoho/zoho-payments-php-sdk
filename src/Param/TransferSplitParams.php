<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class TransferSplitParams
{
    public function __construct(
        public readonly string $connectedAccountId,
        public readonly string $amount,
        public readonly ?string $description = null,
    ) {
        ParamHelpers::require($connectedAccountId, 'connected_account_id');
        ParamHelpers::require($amount, 'amount');
        ParamValidator::validateDescription($description);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'connected_account_id' => $this->connectedAccountId,
            'amount' => $this->amount,
            'description' => $this->description,
        ];
    }
}
