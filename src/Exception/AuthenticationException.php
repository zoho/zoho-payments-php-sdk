<?php

declare(strict_types=1);

namespace Zoho\Payments\Exception;

class AuthenticationException extends ZohoPaymentsAPIException
{
    public function __construct(?string $codeString, ?string $apiErrorMessage)
    {
        parent::__construct(401, $codeString, $apiErrorMessage);
    }
}
