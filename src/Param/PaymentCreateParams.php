<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentCreateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly string $customerId,
        public readonly string $paymentMethodId,
        public readonly float $amount,
        public readonly string $currency,
        public readonly ?bool $customerOnSession = null,
        public readonly ?BrowserInfo $browserInfo = null,
        public readonly ?string $statementDescriptor = null,
        public readonly ?string $description = null,
        public readonly ?PostalAddressParams $shippingAddress = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::require($customerId, 'customer_id');
        ParamHelpers::require($paymentMethodId, 'payment_method_id');
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($currency, 'currency');
        ParamValidator::validateDescription($description);
        MetaDataValidator::validate($metaData);
        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'payment_method_id' => $this->paymentMethodId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'customer_on_session' => $this->customerOnSession,
            'browser_info' => $this->browserInfo?->toArray(),
            'statement_descriptor' => $this->statementDescriptor,
            'description' => $this->description,
            'shipping_address' => $this->shippingAddress?->toArray(),
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
