<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class HostedPageResponse
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $successUrl = null,
        public readonly ?string $failureUrl = null,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?string $udf1 = null,
        public readonly ?string $udf2 = null,
        public readonly ?string $udf3 = null,
        public readonly ?string $udf4 = null,
        public readonly ?string $udf5 = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            description: Coerce::optStr($data, 'description'),
            successUrl: Coerce::optStr($data, 'success_url'),
            failureUrl: Coerce::optStr($data, 'failure_url'),
            name: Coerce::optStr($data, 'name'),
            email: Coerce::optStr($data, 'email'),
            phone: Coerce::optStr($data, 'phone'),
            phoneCountryCode: Coerce::optStr($data, 'phone_country_code'),
            udf1: Coerce::optStr($data, 'udf1'),
            udf2: Coerce::optStr($data, 'udf2'),
            udf3: Coerce::optStr($data, 'udf3'),
            udf4: Coerce::optStr($data, 'udf4'),
            udf5: Coerce::optStr($data, 'udf5'),
        );
    }
}
