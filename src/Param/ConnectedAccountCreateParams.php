<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class ConnectedAccountCreateParams
{
    public function __construct(
        public readonly string $accountName,
        public readonly string $emailId,
        public readonly string $pan,
        public readonly string $mcc,
        public readonly string $businessDescription,
        public readonly ConnectedAccountBankAccountParams $connectedAccountBankAccount,
    ) {
        ParamHelpers::require($accountName, 'account_name');
        ParamHelpers::require($emailId, 'email_id');
        ParamHelpers::require($pan, 'pan');
        ParamHelpers::require($mcc, 'mcc');
        ParamHelpers::require($businessDescription, 'business_description');
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'account_name' => $this->accountName,
            'email_id' => $this->emailId,
            'pan' => $this->pan,
            'mcc' => $this->mcc,
            'business_description' => $this->businessDescription,
            'connected_account_bank_account' => $this->connectedAccountBankAccount->toArray(),
        ];
    }
}