<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class NotifyCustomer
{
    public readonly ?bool $email;
    public readonly ?bool $sms;

    public function __construct(?bool $email = null, ?bool $sms = null)
    {
        $this->email = $email;
        $this->sms = $sms;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Coerce::optBool($data, 'email'),
            sms: Coerce::optBool($data, 'sms'),
        );
    }
}
