<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PayoutTransactionListParams implements PaginationParams
{
    public function __construct(
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
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
