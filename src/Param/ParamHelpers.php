<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** Internal helpers for param constructors: required-field validation, any-field-required checks, metadata flattening. */
final class ParamHelpers
{
    // Raises if $value is null or an empty string.
    public static function require($value, string $name): void
    {
        if ($value === null) {
            throw new \InvalidArgumentException(sprintf('%s is required', $name));
        }
        if (is_string($value) && $value === '') {
            throw new \InvalidArgumentException(sprintf('%s must not be empty', $name));
        }
    }

    /** @param array<string, mixed> $fields */
    public static function requireAnyField(array $fields): void
    {
        foreach ($fields as $v) {
            if ($v !== null) {
                return;
            }
        }
        throw new \InvalidArgumentException('at least one field must be provided');
    }

    /**
     * @param list<MetaDataParams>|null $metaData
     * @return list<array<string, mixed>>|null
     */
    public static function metaDataToList(?array $metaData): ?array
    {
        if ($metaData === null) {
            return null;
        }
        $out = [];
        foreach ($metaData as $m) {
            $out[] = $m->toArray();
        }
        return $out;
    }

    private function __construct()
    {
    }
}
