<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class PaymentSessionCreateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly ?int $expiresIn = null,
        ?array $metaData = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $referenceNumber = null,
        public readonly ?int $maxRetryCount = null,
        public readonly ?ConfigurationsParams $configurations = null,
    ) {
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($currency, 'currency');
        ParamHelpers::require($description, 'description');
        if ($expiresIn !== null && ($expiresIn < 300 || $expiresIn > 900)) {
            throw new \InvalidArgumentException('expires_in must be between 300 and 900 seconds');
        }
        if ($maxRetryCount !== null && ($maxRetryCount < 1 || $maxRetryCount > 5)) {
            throw new \InvalidArgumentException('max_retry_count must be between 1 and 5');
        }
        ParamValidator::validateDescription($description);
        ParamValidator::validateInvoiceNumber($invoiceNumber);
        ParamValidator::validateReferenceNumber($referenceNumber);
        MetaDataValidator::validate($metaData);

        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'description' => $this->description,
            'expires_in' => $this->expiresIn,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
            'invoice_number' => $this->invoiceNumber,
            'reference_number' => $this->referenceNumber,
            'max_retry_count' => $this->maxRetryCount,
            'configurations' => $this->configurations?->toArray(),
        ];
    }
}
