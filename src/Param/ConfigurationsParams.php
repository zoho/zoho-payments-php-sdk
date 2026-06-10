<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class ConfigurationsParams
{
    /** @var list<string>|null */
    public readonly ?array $allowedPaymentMethods;
    public readonly ?HostedPageParams $hostedPageParameters;

    /** @param list<string>|null $allowedPaymentMethods */
    public function __construct(
        ?array $allowedPaymentMethods = null,
        ?HostedPageParams $hostedPageParameters = null,
    ) {
        $this->allowedPaymentMethods = $allowedPaymentMethods === null || $allowedPaymentMethods === []
            ? null
            : array_values($allowedPaymentMethods);
        $this->hostedPageParameters = $hostedPageParameters;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'allowed_payment_methods' => $this->allowedPaymentMethods,
            'hosted_page_parameters' => $this->hostedPageParameters?->toArray(),
        ];
    }
}
