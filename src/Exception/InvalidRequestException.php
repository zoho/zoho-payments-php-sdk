<?php

declare(strict_types=1);

namespace Zoho\Payments\Exception;

class InvalidRequestException extends ZohoPaymentsAPIException
{
    public function __construct(int $httpStatusCode, ?string $codeString, ?string $apiErrorMessage)
    {
        parent::__construct($httpStatusCode, $codeString, $apiErrorMessage);
    }
}
