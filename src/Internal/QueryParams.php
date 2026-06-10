<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

/** Ordered, URL-encoded, repeat-tolerant query string builder; nulls are dropped, booleans render as "true"/"false". */
final class QueryParams
{
    /** @var list<array{0: string, 1: string}> */
    private array $entries = [];

    /** @param string|int|float|bool|null $value */
    public function add(string $key, $value): self
    {
        if ($value === null) {
            return $this;
        }
        if (is_bool($value)) {
            $this->entries[] = [$key, $value ? 'true' : 'false'];
        } else {
            $this->entries[] = [$key, (string) $value];
        }
        return $this;
    }

    public function addAll(?QueryParams $other): self
    {
        if ($other !== null) {
            foreach ($other->entries as $entry) {
                $this->entries[] = $entry;
            }
        }
        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->entries === [];
    }

    public function toQueryString(): string
    {
        $parts = [];
        foreach ($this->entries as [$k, $v]) {
            $parts[] = rawurlencode($k) . '=' . rawurlencode($v);
        }
        return implode('&', $parts);
    }
}
