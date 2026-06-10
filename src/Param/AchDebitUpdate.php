<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class AchDebitUpdate
{
    public function __construct(public readonly ?string $accountHolderType = null)
    {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['account_holder_type' => $this->accountHolderType];
    }
}
