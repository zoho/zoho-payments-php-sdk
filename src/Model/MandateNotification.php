<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class MandateNotification
{
    public function __construct(
        public readonly ?string $mandateId = null,
        public readonly ?string $mandateNotificationId = null,
        public readonly ?string $customerId = null,
        public readonly ?string $mandateAmount = null,
        public readonly ?string $currency = null,
        public readonly ?string $amountRule = null,
        public readonly ?string $notificationAmount = null,
        public readonly ?string $notificationStatus = null,
        public readonly ?string $description = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $amount = null,
        public readonly ?int $notificationDate = null,
        public readonly ?int $executionDate = null,
        public readonly ?MandatePaymentMethod $paymentMethod = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            mandateId: Coerce::optStr($data, 'mandate_id'),
            mandateNotificationId: Coerce::optStr($data, 'mandate_notification_id'),
            customerId: Coerce::optStr($data, 'customer_id'),
            mandateAmount: Coerce::optStr($data, 'mandate_amount'),
            currency: Coerce::optStr($data, 'currency'),
            amountRule: Coerce::optStr($data, 'amount_rule'),
            notificationAmount: Coerce::optStr($data, 'notification_amount'),
            notificationStatus: Coerce::optStr($data, 'notification_status'),
            description: Coerce::optStr($data, 'description'),
            invoiceNumber: Coerce::optStr($data, 'invoice_number'),
            amount: Coerce::optStr($data, 'amount'),
            notificationDate: Coerce::optInt($data, 'notification_date'),
            executionDate: Coerce::optInt($data, 'execution_date'),
            paymentMethod: Coerce::optObj($data, 'payment_method', [MandatePaymentMethod::class, 'fromArray']),
        );
    }
}
