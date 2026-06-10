<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class NetBanking
{
    public function __construct(
        public readonly ?string $bankName = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(bankName: Coerce::optStr($data, 'bank_name'));
    }
}
