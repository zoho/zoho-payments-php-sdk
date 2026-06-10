<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

/** Browser metadata for 3DS / customer-on-session flows. */
final class BrowserInfo
{
    public function __construct(
        public readonly ?string $userAgent = null,
        public readonly ?string $acceptHeader = null,
        public readonly ?int $screenHeight = null,
        public readonly ?int $screenWidth = null,
        public readonly ?string $language = null,
        public readonly ?int $timeZoneOffset = null,
        public readonly ?int $colorDepth = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'user_agent' => $this->userAgent,
            'accept_header' => $this->acceptHeader,
            'screen_height' => $this->screenHeight,
            'screen_width' => $this->screenWidth,
            'language' => $this->language,
            'time_zone_offset' => $this->timeZoneOffset,
            'color_depth' => $this->colorDepth,
        ];
    }
}
