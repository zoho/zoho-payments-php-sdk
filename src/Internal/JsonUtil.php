<?php

declare(strict_types=1);

namespace Zoho\Payments\Internal;

use Zoho\Payments\Exception\ZohoPaymentsException;
use Zoho\Payments\Model\PageContext;

/** JSON helpers: null-stripping serialization and envelope unwrapping. */
final class JsonUtil
{
    // Recursively drops null values before encoding.
    public static function toJson($value): string
    {
        $stripped = self::stripNulls($value);
        $json = json_encode($stripped, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new ZohoPaymentsException('Failed to encode JSON: ' . json_last_error_msg());
        }
        return $json;
    }

    private static function stripNulls($value)
    {
        if (is_array($value)) {
            $isList = array_is_list($value);
            $out = [];
            foreach ($value as $k => $v) {
                if ($v === null) {
                    if ($isList) {
                        $out[] = null;
                    }
                    continue;
                }
                $stripped = self::stripNulls($v);
                if ($isList) {
                    $out[] = $stripped;
                } else {
                    $out[$k] = $stripped;
                }
            }
            return $out;
        }
        if (is_object($value) && method_exists($value, 'toArray')) {
            /** @var array<string, mixed> $arr */
            $arr = $value->toArray();
            return self::stripNulls($arr);
        }
        return $value;
    }

    /** @return array<string, mixed> */
    public static function parseObject(string $text): array
    {
        try {
            $data = json_decode($text, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exc) {
            throw new ZohoPaymentsException('Invalid JSON in response: ' . $exc->getMessage(), $exc);
        }
        if (!is_array($data) || (count($data) > 0 && array_is_list($data))) {
            throw new ZohoPaymentsException('Expected JSON object in response');
        }
        /** @var array<string, mixed> $data */
        return $data;
    }

    /**
     * @param array<string, mixed>|null $body
     * @return array<string, mixed>|null
     */
    public static function getObject(?array $body, string ...$keys): ?array
    {
        if ($body === null || $body === []) {
            return null;
        }
        foreach ($keys as $key) {
            $value = $body[$key] ?? null;
            if (is_array($value) && (!array_is_list($value) || $value === [])) {
                /** @var array<string, mixed> $value */
                return $value;
            }
        }
        return null;
    }

    /**
     * @param array<string, mixed>|null $body
     * @return array<string, mixed>
     */
    public static function getObjectRequired(?array $body, string ...$keys): array
    {
        $obj = self::getObject($body, ...$keys);
        if ($obj === null) {
            throw new ZohoPaymentsException(
                'Expected JSON object under one of keys: ' . implode(', ', $keys),
            );
        }
        return $obj;
    }

    /**
     * @param array<string, mixed>|null $body
     * @return list<mixed>
     */
    public static function listFromBody(?array $body, string ...$keys): array
    {
        if ($body === null || $body === []) {
            return [];
        }
        foreach ($keys as $key) {
            $value = $body[$key] ?? null;
            if (is_array($value) && (array_is_list($value) || $value === [])) {
                /** @var list<mixed> $value */
                return $value;
            }
        }
        return [];
    }

    /**
     * @template T
     * @param array<string, mixed> $responseBody
     * @param callable(array<string, mixed>): T $fromArray
     * @return T
     */
    public static function unwrap(array $responseBody, callable $fromArray, string ...$candidateKeys)
    {
        $inner = self::getObjectRequired($responseBody, ...$candidateKeys);
        return $fromArray($inner);
    }

    /** @param array<string, mixed>|null $body */
    public static function readPageContext(?array $body): PageContext
    {
        $pc = self::getObject($body, 'page_context');
        if ($pc === null) {
            return new PageContext();
        }
        return PageContext::fromArray($pc);
    }

    private function __construct()
    {
    }
}
