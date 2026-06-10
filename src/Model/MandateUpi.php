<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class MandateUpi
{
    public function __construct(public readonly ?string $upiId = null)
    {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(upiId: Coerce::optStr($data, 'upi_id'));
    }
}
