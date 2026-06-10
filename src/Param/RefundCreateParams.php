<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class RefundCreateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly float $amount,
        public readonly string $reason,
        public readonly string $type,
        public readonly ?string $description = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::require($amount, 'amount');
        ParamHelpers::require($reason, 'reason');
        ParamHelpers::require($type, 'type');
        ParamValidator::validateDescription($description);
        MetaDataValidator::validate($metaData);
        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'reason' => $this->reason,
            'type' => $this->type,
            'description' => $this->description,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
