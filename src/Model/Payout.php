<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Payout
{
    public function __construct(
        public readonly ?string $payoutId = null,
        public readonly ?string $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $failureCode = null,
        public readonly ?string $failureMessage = null,
        public readonly ?string $statementDescriptor = null,
        public readonly ?string $payoutMethod = null,
        public readonly ?string $initiatedTime = null,
        public readonly ?string $arrivalDate = null,
        public readonly ?string $processedDate = null,
        public readonly ?string $type = null,
        public readonly ?string $payoutBankReferenceId = null,
        public readonly ?PayoutBankAccountDetails $bankAccountDetails = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            payoutId: Coerce::optStr($data, 'payout_id'),
            amount: Coerce::optStr($data, 'amount'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
            failureCode: Coerce::optStr($data, 'failure_code'),
            failureMessage: Coerce::optStr($data, 'failure_message'),
            statementDescriptor: Coerce::optStr($data, 'statement_descriptor'),
            payoutMethod: Coerce::optStr($data, 'payout_method'),
            initiatedTime: Coerce::optStr($data, 'initiated_time'),
            arrivalDate: Coerce::optStr($data, 'arrival_date'),
            processedDate: Coerce::optStr($data, 'processed_date'),
            type: Coerce::optStr($data, 'type'),
            payoutBankReferenceId: Coerce::optStr($data, 'payout_bank_reference_id'),
            bankAccountDetails: Coerce::optObj($data, 'bank_account_details', [PayoutBankAccountDetails::class, 'fromArray']),
        );
    }
}
