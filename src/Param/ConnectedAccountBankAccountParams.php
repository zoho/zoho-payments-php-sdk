<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

// Bank account details for the connected account being created.
final class ConnectedAccountBankAccountParams
{
    public function __construct(
        public readonly string $routingNumber,
        public readonly string $accountNumber,
    ) {
        ParamHelpers::require($routingNumber, 'routing_number');
        ParamHelpers::require($accountNumber, 'account_number');
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'routing_number' => $this->routingNumber,
            'account_number' => $this->accountNumber,
        ];
    }
}