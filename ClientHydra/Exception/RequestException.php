<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Exception;

use Throwable;

class RequestException extends ClientHydraException
{
    public function __construct($message = '', $body = null, Throwable $previous = null)
    {
        $message = \sprintf('An error occurred during process request. Error : %s. Body : %s', $message, $body);

        parent::__construct($message, 0, $previous);
    }
}
