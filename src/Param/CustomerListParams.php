<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class CustomerListParams implements PaginationParams
{
    public function __construct(
        public readonly ?string $filterBy = null,
        public readonly ?string $fromDate = null,
        public readonly ?string $toDate = null,
        public readonly ?int $perPage = null,
        public readonly ?int $page = null,
    ) {
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    /** @return array<string, mixed> */
    public function toQuery(): array
    {
        return [
            'filter_by' => $this->filterBy,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
