<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\QueryParams;

/** Helper for turning a list-param toQuery() map into a QueryParams. */
final class QueryBuilder
{
    /** @param array<string, mixed>|null $params */
    public static function from(?array $params): QueryParams
    {
        $q = new QueryParams();
        if ($params === null) {
            return $q;
        }
        foreach ($params as $key => $value) {
            if (is_string($value) || is_int($value) || is_float($value) || is_bool($value) || $value === null) {
                $q->add($key, $value);
            } else {
                $q->add($key, (string) $value);
            }
        }
        return $q;
    }

    private function __construct()
    {
    }
}
