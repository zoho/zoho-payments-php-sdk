<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class PaymentSession
{
    /**
     * @param list<PaymentSessionPayment> $payments
     * @param list<MetaData> $metaData
     */
    public function __construct(
        public readonly ?string $paymentsSessionId = null,
        public readonly ?string $accessKey = null,
        public readonly ?string $currency = null,
        public readonly ?string $amount = null,
        public readonly ?string $status = null,
        public readonly ?int $createdTime = null,
        public readonly ?int $expiryTime = null,
        public readonly array $payments = [],
        public readonly array $metaData = [],
        public readonly ?string $description = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?int $maxRetryCount = null,
        public readonly ?Configurations $configurations = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentsSessionId: Coerce::optStr($data, 'payments_session_id'),
            accessKey: Coerce::optStr($data, 'access_key'),
            currency: Coerce::optStr($data, 'currency'),
            amount: Coerce::optStr($data, 'amount'),
            status: Coerce::optStr($data, 'status'),
            createdTime: Coerce::optInt($data, 'created_time'),
            expiryTime: Coerce::optInt($data, 'expiry_time'),
            payments: Coerce::optList($data, 'payments', [PaymentSessionPayment::class, 'fromArray']),
            metaData: Coerce::optList($data, 'meta_data', [MetaData::class, 'fromArray']),
            description: Coerce::optStr($data, 'description'),
            invoiceNumber: Coerce::optStr($data, 'invoice_number'),
            referenceNumber: Coerce::optStr($data, 'reference_number'),
            maxRetryCount: Coerce::optInt($data, 'max_retry_count'),
            configurations: Coerce::optObj($data, 'configurations', [Configurations::class, 'fromArray']),
        );
    }
}
