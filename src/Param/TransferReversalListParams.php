<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class TransferReversalListParams implements PaginationParams
{
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?string $filterBy = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $connectedAccountId = null,
        public readonly ?string $transferId = null,
        public readonly ?string $refundId = null,
        public readonly ?string $fromDate = null,
        public readonly ?string $toDate = null,
        public readonly ?string $sortColumn = null,
        public readonly ?string $sortOrder = null,
        public readonly ?string $searchText = null,
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
            'filter_by' => $this->filterBy,
            'payment_id' => $this->paymentId,
            'connected_account_id' => $this->connectedAccountId,
            'transfer_id' => $this->transferId,
            'refund_id' => $this->refundId,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'sort_column' => $this->sortColumn,
            'sort_order' => $this->sortOrder,
            'search_text' => $this->searchText,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
