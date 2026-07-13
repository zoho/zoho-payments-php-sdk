<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class TransferCreateResponse
{
    /** @param list<TransferSplit> $splits */
    public function __construct(
        public readonly array $splits = [],
        public readonly ?string $status = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            splits: Coerce::optList($data, 'splits', [TransferSplit::class, 'fromArray']),
            status: Coerce::optStr($data, 'status'),
        );
    }
}
