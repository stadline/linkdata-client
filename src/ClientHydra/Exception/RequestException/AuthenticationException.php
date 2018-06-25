<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Exception\RequestException;

use Throwable;

class AuthenticationException extends RequestException
{
    public function __construct($message = '', Throwable $previous = null)
    {
        $message = \sprintf('Error : %s. An error occurred during process request.', $message);

        parent::__construct($message, 0, $previous);
    }
}
