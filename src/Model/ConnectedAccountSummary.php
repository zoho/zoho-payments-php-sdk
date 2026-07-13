<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountSummary
{
    public function __construct(
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $accountName = null,
        public readonly ?string $emailId = null,
        public readonly ?string $underWritingStatus = null,
        public readonly ?string $transferStatus = null,
        public readonly ?string $createdBy = null,
        public readonly ?string $lastModifiedBy = null,
        public readonly ?string $createdTime = null,
        public readonly ?string $lastModifiedTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            connectedAccountId: Coerce::optStr($data, 'connected_account_id'),
            accountName: Coerce::optStr($data, 'account_name'),
            emailId: Coerce::optStr($data, 'email_id'),
            underWritingStatus: Coerce::optStr($data, 'under_writing_status'),
            transferStatus: Coerce::optStr($data, 'transfer_status'),
            createdBy: Coerce::optStr($data, 'created_by'),
            lastModifiedBy: Coerce::optStr($data, 'last_modified_by'),
            createdTime: Coerce::optStr($data, 'created_time'),
            lastModifiedTime: Coerce::optStr($data, 'last_modified_time'),
        );
    }
}
