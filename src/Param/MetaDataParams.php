<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MetaDataParams
{
    public readonly string $key;
    public readonly ?string $value;

    public function __construct(string $key, ?string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['key' => $this->key, 'value' => $this->value];
    }
}
