<?php

declare(strict_types=1);

namespace Zoho\Payments\Exception;

class RateLimitException extends ZohoPaymentsAPIException
{
    public function __construct(?string $codeString, ?string $apiErrorMessage)
    {
        parent::__construct(429, $codeString, $apiErrorMessage);
    }
}
