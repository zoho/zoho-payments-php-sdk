<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class NotifyCustomerParams
{
    public readonly ?bool $email;
    public readonly ?bool $sms;

    public function __construct(?bool $email = null, ?bool $sms = null)
    {
        $this->email = $email;
        $this->sms = $sms;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['email' => $this->email, 'sms' => $this->sms];
    }
}
