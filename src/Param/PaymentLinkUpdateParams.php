<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** All fields are optional, but at least one must be provided. */
final class PaymentLinkUpdateParams
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $referenceId = null,
        public readonly ?string $returnUrl = null,
        public readonly ?NotifyCustomerParams $notifyCustomer = null,
        public readonly ?PaymentLinkConfigurationsParams $configurations = null,
    ) {
        ParamHelpers::requireAnyField([
            'description' => $description,
            'email' => $email,
            'phone' => $phone,
            'phone_country_code' => $phoneCountryCode,
            'expires_at' => $expiresAt,
            'reference_id' => $referenceId,
            'return_url' => $returnUrl,
            'notify_customer' => $notifyCustomer,
            'configurations' => $configurations,
        ]);
        ParamValidator::validateDescription($description);
        ParamValidator::validateReferenceNumber($referenceId);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_country_code' => $this->phoneCountryCode,
            'expires_at' => $this->expiresAt,
            'reference_id' => $this->referenceId,
            'return_url' => $this->returnUrl,
            'notify_customer' => $this->notifyCustomer?->toArray(),
            'configurations' => $this->configurations?->toArray(),
        ];
    }
}
