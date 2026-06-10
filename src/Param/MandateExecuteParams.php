<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MandateExecuteParams
{
    public function __construct(
        public readonly string $customerId,
        public readonly string $mandateId,
        public readonly string $paymentsSessionId,
        public readonly string $invoiceNumber,
        public readonly float $amount,
        public readonly ?string $mandateNotificationId = null,
        public readonly ?string $receiptEmail = null,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?string $description = null,
        public readonly ?string $referenceNumber = null,
    ) {
        ParamHelpers::require($customerId, 'customer_id');
        ParamHelpers::require($mandateId, 'mandate_id');
        ParamHelpers::require($paymentsSessionId, 'payments_session_id');
        ParamHelpers::require($invoiceNumber, 'invoice_number');
        ParamHelpers::require($amount, 'amount');
        ParamValidator::validateDescription($description);
        ParamValidator::validateInvoiceNumber($invoiceNumber);
        ParamValidator::validateReferenceNumber($referenceNumber);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'mandate_id' => $this->mandateId,
            'payments_session_id' => $this->paymentsSessionId,
            'invoice_number' => $this->invoiceNumber,
            'amount' => $this->amount,
            'mandate_notification_id' => $this->mandateNotificationId,
            'receipt_email' => $this->receiptEmail,
            'phone' => $this->phone,
            'phone_country_code' => $this->phoneCountryCode,
            'description' => $this->description,
            'reference_number' => $this->referenceNumber,
        ];
    }
}
