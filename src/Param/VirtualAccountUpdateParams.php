<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** All fields are optional, but at least one must be provided. */
final class VirtualAccountUpdateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?float $minimumAmount = null,
        public readonly ?float $maximumAmount = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $referenceNumber = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::requireAnyField([
            'description' => $description,
            'minimum_amount' => $minimumAmount,
            'maximum_amount' => $maximumAmount,
            'expires_at' => $expiresAt,
            'reference_number' => $referenceNumber,
            'meta_data' => $metaData,
        ]);
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
            'minimum_amount' => $this->minimumAmount,
            'maximum_amount' => $this->maximumAmount,
            'expires_at' => $this->expiresAt,
            'reference_number' => $this->referenceNumber,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
