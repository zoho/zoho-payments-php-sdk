<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MandateNotifyParams
{
    public function __construct(
        public readonly string $mandateId,
        public readonly float $amount,
        public readonly string $executionDate,
        public readonly string $description,
        public readonly string $invoiceNumber,
    ) {
        ParamHelpers::require($mandateId, 'mandate_id');
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($executionDate, 'execution_date');
        ParamHelpers::require($description, 'description');
        ParamHelpers::require($invoiceNumber, 'invoice_number');
        ParamValidator::validateDescription($description);
        ParamValidator::validateInvoiceNumber($invoiceNumber);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'mandate_id' => $this->mandateId,
            'amount' => $this->amount,
            'execution_date' => $this->executionDate,
            'description' => $this->description,
            'invoice_number' => $this->invoiceNumber,
        ];
    }
}
