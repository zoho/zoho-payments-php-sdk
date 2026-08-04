<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccount
{
    /** @param list<ConnectedAccountBankAccount> $connectedAccountBankAccounts */
    public function __construct(
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $emailId = null,
        public readonly ?string $accountName = null,
        public readonly ?string $pan = null,
        public readonly ?string $mcc = null,
        public readonly ?string $businessDescription = null,
        public readonly ?string $underWritingStatus = null,
        public readonly ?string $transferStatus = null,
        public readonly ?string $payoutStatus = null,
        public readonly ?int $payoutDelayDays = null,
        public readonly ?string $payoutStatementDescriptor = null,
        public readonly ?string $statementDescriptorRestrictedChars = null,
        public readonly ?string $createdBy = null,
        public readonly ?string $lastModifiedBy = null,
        public readonly ?string $createdTime = null,
        public readonly ?string $lastModifiedTime = null,
        public readonly array $connectedAccountBankAccounts = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            emailId: Coerce::optStr($data, 'email_id'),
            accountName: Coerce::optStr($data, 'account_name'),
            pan: Coerce::optStr($data, 'pan'),
            mcc: Coerce::optStr($data, 'mcc'),
            businessDescription: Coerce::optStr($data, 'business_description'),
            underWritingStatus: Coerce::optStr($data, 'under_writing_status'),
            transferStatus: Coerce::optStr($data, 'transfer_status'),
            payoutStatus: Coerce::optStr($data, 'payout_status'),
            payoutDelayDays: Coerce::optInt($data, 'payout_delay_days'),
            payoutStatementDescriptor: Coerce::optStr($data, 'payout_statement_descriptor'),
            statementDescriptorRestrictedChars: Coerce::optStr($data, 'statement_descriptor_restricted_chars'),
            createdBy: Coerce::optStr($data, 'created_by'),
            lastModifiedBy: Coerce::optStr($data, 'last_modified_by'),
            createdTime: Coerce::optStr($data, 'created_time'),
            lastModifiedTime: Coerce::optStr($data, 'last_modified_time'),
            connectedAccountBankAccounts: Coerce::optList($data, 'connected_account_bank_accounts', [ConnectedAccountBankAccount::class, 'fromArray']),
        );
    }
}
