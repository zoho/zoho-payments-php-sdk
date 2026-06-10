<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Upi
{
    public function __construct(
        public readonly ?string $upiId = null,
        public readonly ?string $channel = null,
        public readonly ?string $accountType = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            upiId: Coerce::optStr($data, 'upi_id'),
            channel: Coerce::optStr($data, 'channel'),
            accountType: Coerce::optStr($data, 'account_type'),
        );
    }
}
