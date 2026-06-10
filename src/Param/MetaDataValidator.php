<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MetaDataValidator
{
    public const MAX_ENTRIES = 5;
    public const MAX_KEY_LENGTH = 20;
    public const MAX_VALUE_LENGTH = 500;

    /** @param list<MetaDataParams>|null $metaData */
    public static function validate(?array $metaData): void
    {
        if ($metaData === null) {
            return;
        }
        if (count($metaData) > self::MAX_ENTRIES) {
            throw new \InvalidArgumentException(sprintf(
                'meta_data can have at most %d entries',
                self::MAX_ENTRIES,
            ));
        }
        foreach ($metaData as $entry) {
            if (!$entry instanceof MetaDataParams) {
                throw new \InvalidArgumentException('meta_data entry must be a MetaDataParams instance');
            }
            if ($entry->key === '') {
                throw new \InvalidArgumentException('meta_data key must not be empty');
            }
            if (strlen($entry->key) > self::MAX_KEY_LENGTH) {
                throw new \InvalidArgumentException(sprintf(
                    'meta_data key must be at most %d characters',
                    self::MAX_KEY_LENGTH,
                ));
            }
            if ($entry->value !== null && strlen($entry->value) > self::MAX_VALUE_LENGTH) {
                throw new \InvalidArgumentException(sprintf(
                    'meta_data value must be at most %d characters',
                    self::MAX_VALUE_LENGTH,
                ));
            }
        }
    }

    private function __construct()
    {
    }
}
