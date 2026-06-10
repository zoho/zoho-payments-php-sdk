<?php

declare(strict_types=1);

namespace Zoho\Payments\Exception;

class ZohoPaymentsAPIException extends ZohoPaymentsException
{
    public readonly int $httpStatusCode;
    public readonly ?string $codeString;
    public readonly ?string $apiErrorMessage;

    public function __construct(int $httpStatusCode, ?string $codeString, ?string $apiErrorMessage)
    {
        parent::__construct(sprintf(
            'API error (HTTP %d): code=%s, message=%s',
            $httpStatusCode,
            $codeString ?? 'null',
            $apiErrorMessage ?? 'null',
        ));
        $this->httpStatusCode = $httpStatusCode;
        $this->codeString = $codeString;
        $this->apiErrorMessage = $apiErrorMessage;
    }
}
