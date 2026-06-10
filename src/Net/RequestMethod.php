<?php

declare(strict_types=1);

namespace Zoho\Payments\Net;

enum RequestMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
