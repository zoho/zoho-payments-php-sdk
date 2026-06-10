<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Refund
{
    /** @param list<MetaData> $metaData */
    public function __construct(
        public readonly ?string $refundId = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?string $amount = null,
        public readonly ?string $defaultCurrencyAmount = null,
        public readonly ?string $type = null,
        public readonly ?string $reason = null,
        public readonly ?string $description = null,
        public readonly ?string $status = null,
        public readonly ?string $networkReferenceNumber = null,
        public readonly ?string $failureReason = null,
        public readonly ?int $date = null,
        public readonly array $metaData = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            refundId: Coerce::optStr($data, 'refund_id'),
            paymentId: Coerce::optStr($data, 'payment_id'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            amount: Coerce::optStr($data, 'amount'),
            defaultCurrencyAmount: Coerce::optStr($data, 'default_currency_amount'),
            type: Coerce::optStr($data, 'type'),
            reason: Coerce::optStr($data, 'reason'),
            description: Coerce::optStr($data, 'description'),
            status: Coerce::optStr($data, 'status'),
            networkReferenceNumber: Coerce::optStr($data, 'network_reference_number'),
            failureReason: Coerce::optStr($data, 'failure_reason'),
            date: Coerce::optInt($data, 'date'),
            metaData: Coerce::optList($data, 'meta_data', [MetaData::class, 'fromArray']),
        );
    }
}
