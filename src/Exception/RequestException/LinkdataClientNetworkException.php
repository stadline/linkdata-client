<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Exception;

use Throwable;

class LinkdataClientNetworkException extends LinkdataClientRequestException
{
    public function __construct($message = '', $body = null, Throwable $previous = null)
    {
        $message = \sprintf('Network Exception while requesting API : %s with %s body', $message, $body);

        parent::__construct($message, 0, $previous);
    }
}
