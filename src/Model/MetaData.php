<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class MetaData
{
    public readonly ?string $key;
    public readonly ?string $value;

    public function __construct(?string $key = null, ?string $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            key: Coerce::optStr($data, 'key'),
            value: Coerce::optStr($data, 'value'),
        );
    }
}
