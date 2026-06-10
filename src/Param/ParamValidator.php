<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class ParamValidator
{
    public const MAX_DESCRIPTION_LENGTH = 500;
    public const MAX_INVOICE_NUMBER_LENGTH = 50;
    public const MAX_REFERENCE_LENGTH = 50;

    public static function validateDescription(?string $description): void
    {
        if ($description === null) {
            return;
        }
        if (strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'description must be at most %d characters',
                self::MAX_DESCRIPTION_LENGTH,
            ));
        }
    }

    public static function validateInvoiceNumber(?string $invoiceNumber): void
    {
        if ($invoiceNumber === null) {
            return;
        }
        if (strlen($invoiceNumber) > self::MAX_INVOICE_NUMBER_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'invoice_number must be at most %d characters',
                self::MAX_INVOICE_NUMBER_LENGTH,
            ));
        }
    }

    public static function validateReferenceNumber(?string $referenceNumber): void
    {
        if ($referenceNumber === null) {
            return;
        }
        if (strlen($referenceNumber) > self::MAX_REFERENCE_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'reference number must be at most %d characters',
                self::MAX_REFERENCE_LENGTH,
            ));
        }
    }

    private function __construct()
    {
    }
}
