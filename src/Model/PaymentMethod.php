<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

/** Saved payment method (US edition). */
final class PaymentMethod
{
    public function __construct(
        public readonly ?string $paymentMethodId = null,
        public readonly ?string $customerId = null,
        public readonly ?string $customerName = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $type = null,
        public readonly ?string $status = null,
        public readonly ?string $currency = null,
        public readonly ?string $source = null,
        public readonly ?int $createdTime = null,
        public readonly ?int $lastModifiedTime = null,
        public readonly ?SavedCardDetail $card = null,
        public readonly ?AchDebitDetail $achDebit = null,
        public readonly ?AddressDetail $billingAddress = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentMethodId: Coerce::optStr($data, 'payment_method_id'),
            customerId: Coerce::optStr($data, 'customer_id'),
            customerName: Coerce::optStr($data, 'customer_name'),
            customerEmail: Coerce::optStr($data, 'customer_email'),
            type: Coerce::optStr($data, 'type'),
            status: Coerce::optStr($data, 'status'),
            currency: Coerce::optStr($data, 'currency'),
            source: Coerce::optStr($data, 'source'),
            createdTime: Coerce::optInt($data, 'created_time'),
            lastModifiedTime: Coerce::optInt($data, 'last_modified_time'),
            card: Coerce::optObj($data, 'card', [SavedCardDetail::class, 'fromArray']),
            achDebit: Coerce::optObj($data, 'ach_debit', [AchDebitDetail::class, 'fromArray']),
            billingAddress: Coerce::optObj($data, 'billing_address', [AddressDetail::class, 'fromArray']),
        );
    }
}
