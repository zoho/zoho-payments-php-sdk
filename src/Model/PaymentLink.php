<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentLink
{
    /** @param list<PaymentLinkPayment> $payments */
    public function __construct(
        public readonly ?string $paymentLinkId = null,
        public readonly ?string $url = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $amount = null,
        public readonly ?string $amountPaid = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $email = null,
        public readonly ?string $referenceId = null,
        public readonly ?string $description = null,
        public readonly ?string $returnUrl = null,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?int $createdTime = null,
        public readonly ?string $createdById = null,
        public readonly ?string $createdBy = null,
        public readonly ?string $lastModifiedById = null,
        public readonly ?string $lastModified = null,
        public readonly ?Configurations $configurations = null,
        public readonly array $payments = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentLinkId: Coerce::optStr($data, 'payment_link_id'),
            url: Coerce::optStr($data, 'url'),
            expiresAt: Coerce::optStr($data, 'expires_at'),
            amount: Coerce::optStr($data, 'amount'),
            amountPaid: Coerce::optStr($data, 'amount_paid'),
            currency: Coerce::optStr($data, 'currency'),
            status: Coerce::optStr($data, 'status'),
            email: Coerce::optStr($data, 'email'),
            referenceId: Coerce::optStr($data, 'reference_id'),
            description: Coerce::optStr($data, 'description'),
            returnUrl: Coerce::optStr($data, 'return_url'),
            phone: Coerce::optStr($data, 'phone'),
            phoneCountryCode: Coerce::optStr($data, 'phone_country_code'),
            createdTime: Coerce::optInt($data, 'created_time'),
            createdById: Coerce::optStr($data, 'created_by_id'),
            createdBy: Coerce::optStr($data, 'created_by'),
            lastModifiedById: Coerce::optStr($data, 'last_modified_by_id'),
            lastModified: Coerce::optStr($data, 'last_modified'),
            configurations: Coerce::optObj($data, 'configurations', [Configurations::class, 'fromArray']),
            payments: Coerce::optList($data, 'payments', [PaymentLinkPayment::class, 'fromArray']),
        );
    }
}
