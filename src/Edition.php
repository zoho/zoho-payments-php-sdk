<?php

declare(strict_types=1);

namespace Zoho\Payments;

enum Edition: string
{
    case IN = 'IN';
    case IN_SANDBOX = 'IN_SANDBOX';
    case US = 'US';

    public function baseUrl(): string
    {
        return match ($this) {
            self::IN => 'https://payments.zoho.in/api/v1',
            self::IN_SANDBOX => 'https://paymentssandbox.zoho.in/api/v1',
            self::US => 'https://payments.zoho.com/api/v1',
        };
    }

    public function accountsUrl(): string
    {
        return match ($this) {
            self::IN, self::IN_SANDBOX => 'https://accounts.zoho.in',
            self::US => 'https://accounts.zoho.com',
        };
    }

    public function isUs(): bool
    {
        return $this === self::US;
    }

    public function isIn(): bool
    {
        return $this === self::IN || $this === self::IN_SANDBOX;
    }

    public static function fromString(string $name): self
    {
        if ($name === '') {
            throw new \InvalidArgumentException('edition name must not be empty');
        }
        $upper = strtoupper($name);
        foreach (self::cases() as $case) {
            if ($case->name === $upper) {
                return $case;
            }
        }
        $names = implode(', ', array_map(static fn (self $c) => $c->name, self::cases()));
        throw new \InvalidArgumentException(
            sprintf('unknown edition: %s. Expected one of: %s', $name, $names),
        );
    }
}
