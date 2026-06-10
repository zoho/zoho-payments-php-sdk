<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentLinkCreateParams
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $referenceId = null,
        public readonly ?string $returnUrl = null,
        public readonly ?NotifyCustomerParams $notifyCustomer = null,
        public readonly ?PaymentLinkConfigurationsParams $configurations = null,
    ) {
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($currency, 'currency');
        ParamHelpers::require($description, 'description');
        ParamValidator::validateDescription($description);
        ParamValidator::validateReferenceNumber($referenceId);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
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
