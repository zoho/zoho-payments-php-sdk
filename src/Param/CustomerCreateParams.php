<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class CustomerCreateParams
{
    /** @var list<MetaDataParams>|null */
    public readonly ?array $metaData;

    /** @param list<MetaDataParams>|null $metaData */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        ?array $metaData = null,
    ) {
        ParamHelpers::require($name, 'name');
        ParamHelpers::require($email, 'email');
        MetaDataValidator::validate($metaData);
        $this->metaData = $metaData;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_country_code' => $this->phoneCountryCode,
            'meta_data' => ParamHelpers::metaDataToList($this->metaData),
        ];
    }
}
