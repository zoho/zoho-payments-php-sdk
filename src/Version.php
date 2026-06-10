<?php

declare(strict_types=1);

namespace Zoho\Payments;

final class Version
{
    public const SDK_NAME = 'zoho-payments-php-sdk';
    public const SDK_VERSION = '1.0.0';

    public static function userAgent(): string
    {
        return self::SDK_NAME . '/' . self::SDK_VERSION;
    }

    private function __construct()
    {
    }
}
