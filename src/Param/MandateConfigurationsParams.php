<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MandateConfigurationsParams
{
    public function __construct(public readonly ?HostedPageParams $hostedPageParameters = null)
    {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'hosted_page_parameters' => $this->hostedPageParameters?->toArray(),
        ];
    }
}
