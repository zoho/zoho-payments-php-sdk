<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

interface PaginationParams
{
    public function getPerPage(): ?int;

    public function getPage(): ?int;
}
