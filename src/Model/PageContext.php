<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PageContext
{
    public readonly int $page;
    public readonly int $perPage;
    public readonly int $total;
    public readonly int $totalPages;
    public readonly bool $hasMorePage;

    public function __construct(
        int $page = 0,
        int $perPage = 0,
        int $total = 0,
        int $totalPages = 0,
        bool $hasMorePage = false,
    ) {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
        $this->totalPages = $totalPages;
        $this->hasMorePage = $hasMorePage;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            page: Coerce::optInt($data, 'page') ?? 0,
            perPage: Coerce::optInt($data, 'per_page') ?? 0,
            total: Coerce::optInt($data, 'total') ?? 0,
            totalPages: Coerce::optInt($data, 'total_pages') ?? 0,
            hasMorePage: Coerce::optBool($data, 'has_more_page') ?? false,
        );
    }
}
