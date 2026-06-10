<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class VirtualAccountPaymentListParams implements PaginationParams
{
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?string $sortColumn = null,
        public readonly ?string $sortOrder = null,
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
            'status' => $this->status,
            'sort_column' => $this->sortColumn,
            'sort_order' => $this->sortOrder,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
