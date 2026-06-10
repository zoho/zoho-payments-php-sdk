<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** Hosted-page configuration. `description`, `successUrl` and `failureUrl` are required. */
final class HostedPageParams
{
    public function __construct(
        public readonly string $description,
        public readonly string $successUrl,
        public readonly string $failureUrl,
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
        if ($description === '') {
            throw new \InvalidArgumentException('description is required');
        }
        if ($successUrl === '') {
            throw new \InvalidArgumentException('success_url is required');
        }
        if ($failureUrl === '') {
            throw new \InvalidArgumentException('failure_url is required');
        }
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'success_url' => $this->successUrl,
            'failure_url' => $this->failureUrl,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_country_code' => $this->phoneCountryCode,
            'udf1' => $this->udf1,
            'udf2' => $this->udf2,
            'udf3' => $this->udf3,
            'udf4' => $this->udf4,
            'udf5' => $this->udf5,
        ];
    }
}
