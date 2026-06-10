<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MandateExecutionSessionCreateParams
{
    private const TYPE = 'mandate_execution';

    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $customerId,
        public readonly string $description,
        public readonly string $invoiceNumber,
        public readonly ?int $maxRetryCount = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($currency, 'currency');
        ParamHelpers::require($customerId, 'customer_id');
        ParamHelpers::require($description, 'description');
        ParamHelpers::require($invoiceNumber, 'invoice_number');
        if ($maxRetryCount !== null && ($maxRetryCount < 1 || $maxRetryCount > 3)) {
            throw new \InvalidArgumentException('max_retry_count must be between 1 and 3');
        }
        ParamValidator::validateDescription($description);
        ParamValidator::validateInvoiceNumber($invoiceNumber);
        MetaDataValidator::validate($metaData);
        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'customer_id' => $this->customerId,
            'description' => $this->description,
            'invoice_number' => $this->invoiceNumber,
            'max_retry_count' => $this->maxRetryCount,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
