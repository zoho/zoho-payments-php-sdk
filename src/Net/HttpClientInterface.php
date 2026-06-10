<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

/** Pluggable HTTP transport; implementations raise ConnectionException on network failures. */
interface HttpClientInterface
{
    public function execute(ZohoRequest $request): ZohoResponse;
}
