<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class ConnectedAccountTransactionListParams implements PaginationParams
{
    public function __construct(
        public readonly ?string $sortColumn = null,
        public readonly ?string $transactionType = null,
        public readonly ?string $transactionId = null,
        public readonly ?string $filterBy = null,
        public readonly ?string $fromDate = null,
        public readonly ?string $toDate = null,
        public readonly ?string $paymentMethodType = null,
        public readonly ?string $cardBrand = null,
        public readonly ?string $cardType = null,
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
            'sort_column' => $this->sortColumn,
            'transaction_type' => $this->transactionType,
            'transaction_id' => $this->transactionId,
            'filter_by' => $this->filterBy,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'payment_method_type' => $this->paymentMethodType,
            'card_brand' => $this->cardBrand,
            'card_type' => $this->cardType,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
