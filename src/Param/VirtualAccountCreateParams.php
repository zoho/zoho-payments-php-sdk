<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class VirtualAccountCreateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly string $description,
        public readonly ?string $customerId = null,
        public readonly ?float $minimumAmount = null,
        public readonly ?float $maximumAmount = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $referenceNumber = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::require($description, 'description');
        ParamValidator::validateDescription($description);
        ParamValidator::validateReferenceNumber($referenceNumber);
        MetaDataValidator::validate($metaData);
        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'customer_id' => $this->customerId,
            'minimum_amount' => $this->minimumAmount,
            'maximum_amount' => $this->maximumAmount,
            'expires_at' => $this->expiresAt,
            'reference_number' => $this->referenceNumber,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
