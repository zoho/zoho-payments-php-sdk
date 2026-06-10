<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

/** Shared coercion helpers used by every response-model `fromArray()` factory. */
final class Coerce
{
    /** @param array<string, mixed> $d */
    public static function optStr(array $d, string $key): ?string
    {
        $v = $d[$key] ?? null;
        if ($v === null) {
            return null;
        }
        return is_scalar($v) ? (string) $v : null;
    }

    /** @param array<string, mixed> $d */
    public static function optInt(array $d, string $key): ?int
    {
        $v = $d[$key] ?? null;
        if ($v === null) {
            return null;
        }
        if (is_int($v)) {
            return $v;
        }
        if (is_float($v)) {
            return (int) $v;
        }
        if (is_string($v) && is_numeric($v)) {
            return (int) $v;
        }
        return null;
    }

    /** @param array<string, mixed> $d */
    public static function optFloat(array $d, string $key): ?float
    {
        $v = $d[$key] ?? null;
        if ($v === null) {
            return null;
        }
        if (is_int($v) || is_float($v)) {
            return (float) $v;
        }
        if (is_string($v) && is_numeric($v)) {
            return (float) $v;
        }
        return null;
    }

    /** @param array<string, mixed> $d */
    public static function optBool(array $d, string $key): ?bool
    {
        $v = $d[$key] ?? null;
        if ($v === null) {
            return null;
        }
        return (bool) $v;
    }

    /**
     * @template T
     * @param array<string, mixed> $d
     * @param callable(array<string, mixed>): T $fromArray
     * @return T|null
     */
    public static function optObj(array $d, string $key, callable $fromArray)
    {
        $v = $d[$key] ?? null;
        if (!is_array($v)) {
            return null;
        }
        /** @var array<string, mixed> $v */
        return $fromArray($v);
    }

    /**
     * @template T
     * @param array<string, mixed> $d
     * @param callable(array<string, mixed>): T $elementFromArray
     * @return list<T>
     */
    public static function optList(array $d, string $key, callable $elementFromArray): array
    {
        $v = $d[$key] ?? null;
        if (!is_array($v)) {
            return [];
        }
        $out = [];
        foreach ($v as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                $out[] = $elementFromArray($item);
            }
        }
        return $out;
    }

    /**
     * @param array<string, mixed> $d
     * @return list<string>
     */
    public static function optStrList(array $d, string $key): array
    {
        $v = $d[$key] ?? null;
        if (!is_array($v)) {
            return [];
        }
        $out = [];
        foreach ($v as $item) {
            if ($item !== null && is_scalar($item)) {
                $out[] = (string) $item;
            }
        }
        return $out;
    }

    private function __construct()
    {
    }
}
