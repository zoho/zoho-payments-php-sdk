<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentLinkConfigurationsParams
{
    /** @var list<string>|null */
    public readonly ?array $allowedPaymentMethods;

    /** @param list<string>|null $allowedPaymentMethods */
    public function __construct(?array $allowedPaymentMethods = null)
    {
        $this->allowedPaymentMethods = $allowedPaymentMethods === null || $allowedPaymentMethods === []
            ? null
            : array_values($allowedPaymentMethods);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['allowed_payment_methods' => $this->allowedPaymentMethods];
    }
}
